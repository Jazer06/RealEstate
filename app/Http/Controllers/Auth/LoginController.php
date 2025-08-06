<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\CsrfService;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $csrfService;

    public function __construct(CsrfService $csrfService)
    {
        $this->middleware('guest')->except('logout');
        $this->csrfService = $csrfService;
    }

    public function showLoginForm()
    {
        $token = $this->csrfService->generateToken();
        return view('auth.login', ['custom_csrf_token' => $token]);
    }
    protected function authenticated(Request $request, $user)
    {
        return $user->isAdmin() ? redirect()->route('dashboard') : redirect()->route('home');
    }
}