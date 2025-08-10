<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    public function showResetForm(Request $request, $token = null)
    {
        $resetEmail = $request->query('email');
        if (!$resetEmail) {
            return redirect()->back()->withErrors(['email' => 'Email не указан']);
        }

        return view('auth.reset')->with([
            'token' => $token,
            'resetEmail' => $resetEmail
        ]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = bcrypt($password);
                $user->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', 'Пароль изменён!')
            : back()->withErrors(['email' => __($status)]);
    }
}