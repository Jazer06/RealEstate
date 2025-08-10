<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /**
     * Показываем форму восстановления пароля
     */
    public function showLinkRequestForm()
    {
        return view('auth.email');
    }

    /**
     * Отправляем ссылку для сброса пароля
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', 'Ссылка для сброса пароля отправлена на ваш email.')
            : back()->withErrors(['email' => $this->getErrorMessage($status)]);
    }

    /**
     * Возвращаем понятные сообщения об ошибках на русском
     */
    private function getErrorMessage($status)
    {
        $messages = [
            'passwords.users' => 'Пользователь с таким email не найден.',
            'passwords.throttled' => 'Пожалуйста, подождите перед повторной попыткой.',
            'passwords.sent' => 'Ссылка для сброса пароля уже отправлена.',
            'passwords.token' => 'Ссылка для сброса пароля недействительна.',
        ];

        return $messages[$status] ?? 'Не удалось отправить ссылку для сброса пароля. Проверьте email и попробуйте снова.';
    }
}