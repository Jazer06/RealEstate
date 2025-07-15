<?php
// app/Http/Controllers/Auth/LoginController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    // Не указываем redirectTo напрямую
    // protected $redirectTo = '/dashboard'; — закомментируй или удали

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Переопределяем метод authenticated(), чтобы сделать редирект на основе роли
     */
    protected function authenticated(Request $request, $user)
    {
        if ($user->isAdmin()) {
            return redirect()->route('dashboard');
        }

    return redirect()->route('home');
    }
}