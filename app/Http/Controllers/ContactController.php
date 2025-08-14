<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\WhatsAppSender;
use Illuminate\Http\Request;

/**
 * Контроллер для обработки заявок и отправки уведомлений в WhatsApp.
 */
class ContactController extends Controller
{
    /**
     * Отображает форму для создания новой заявки.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('welcome');
    }

    /**
     * Обрабатывает и сохраняет данные формы, отправляет уведомление в WhatsApp.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:20',
                'regex:/^[а-яА-ЯёЁa-zA-Z\s\-]+$/u',
                'not_regex:/^\d+$/u',
            ],
            'phone' => [
                'required',
                'string',
                'max:20',
                'regex:/^[\d\+\-\s\(\)]{6,20}$/',
            ],
            'description' => 'required|string|max:100',
            'privacy_policy' => 'required|accepted',
        ], [
            'name.regex' => 'Имя может содержать только буквы, пробелы и дефисы.',
            'name.not_regex' => 'Имя не может состоять только из цифр.',
            'phone.regex' => 'Введите корректный номер телефона.',
            'privacy_policy.required' => 'Вы должны согласиться с политикой конфиденциальности.',
            'privacy_policy.accepted' => 'Вы должны согласиться с политикой конфиденциальности.',
        ]);

        $rawPhone = $request->input('phone');
        $digits = preg_replace('/\D/', '', $rawPhone);

        if (strlen($digits) === 11 && $digits[0] === '8') {
            $digits = '7' . substr($digits, 1);
        } elseif (strlen($digits) === 10) {
            $digits = '7' . $digits;
        }

        if (strlen($digits) !== 11 || $digits[0] !== '7') {
            return back()->withErrors(['phone' => 'Некорректный номер телефона.'])->withInput();
        }

        $formattedPhone = "+7 ({$digits[1]}{$digits[2]}{$digits[3]}) {$digits[4]}{$digits[5]}{$digits[6]}-{$digits[7]}{$digits[8]}-{$digits[9]}{$digits[10]}";

        // Сохраняем заявку
        $contact = Contact::create([
            'name' => $request->name,
            'phone' => $formattedPhone,
            'description' => $request->description
        ]);

        // Отправляем в WhatsApp
        $this->sendToWhatsAppGroup($contact);

        return back()->with('success', 'Заявка успешно отправлена!');
    }

    /**
     * Отправляет уведомление о новой заявке в WhatsApp-группу.
     *
     * @param \App\Models\Contact $contact
     * @return void
     */
    private function sendToWhatsAppGroup(Contact $contact)
    {
        $message = "📢 *Новая заявка-Свяжитесь с нами!*\n"
                 . "👤 *Имя:* {$contact->name}\n"
                 . "📞 *Телефон:* {$contact->phone}\n"
                 . "✉️ *Описание:* {$contact->description}\n\n"
                 . "🕒 " . now()->format('d.m.Y H:i');

        $whatsAppSender = new WhatsAppSender();
        $success = $whatsAppSender->send($message);

        if (!$success) {
            return back()->withErrors(['whatsapp' => 'Не удалось отправить сообщение в WhatsApp.'])->withInput();
        }
    }
}