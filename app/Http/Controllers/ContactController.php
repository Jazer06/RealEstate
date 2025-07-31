<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function create()
    {
        return view('welcome'); // Только форма обратной связи
    }

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
                'regex:/^[\d\+\-\s\(\)]{6,20}$/', // разрешаем формат, но не требуем жёстко
            ],
            'description' => 'required|string|max:100',
        ], [
            'name.regex' => 'Имя может содержать только буквы, пробелы и дефисы.',
            'name.not_regex' => 'Имя не может состоять только из цифр.',
            'phone.regex' => 'Введите корректный номер телефона.',
        ]);

        // Нормализуем телефон
        $rawPhone = $request->input('phone');
        $digits = preg_replace('/\D/', '', $rawPhone); // убираем всё, кроме цифр

        // Если начинается с 8 → заменяем на 7
        if (strlen($digits) === 11 && $digits[0] === '8') {
            $digits = '7' . substr($digits, 1);
        }

        // Если 10 цифр и начинается с 967 → значит, +7 пропущен
        if (strlen($digits) === 10) {
            $digits = '7' . $digits;
        }

        // Проверим, что теперь 11 цифр и начинается с 7
        if (strlen($digits) !== 11 || $digits[0] !== '7') {
            return back()->withErrors(['phone' => 'Некорректный номер телефона.'])->withInput();
        }

        // Форматируем для хранения: +7 (967) 004-86-98
        $formattedPhone = "+7 ({$digits[1]}{$digits[2]}{$digits[3]}) {$digits[4]}{$digits[5]}{$digits[6]}-{$digits[7]}{$digits[8]}-{$digits[9]}{$digits[10]}";

        // Сохраняем
        $contact = new Contact();
        $contact->name = $request->name;
        $contact->phone = $formattedPhone; // или храни $digits, если хочешь чистые цифры
        $contact->description = $request->description;
        $contact->save();

        return redirect()->route('home')->with('success', 'Заявка успешно отправлена!');
    }
}