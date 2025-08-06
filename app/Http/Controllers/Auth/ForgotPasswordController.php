<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\CsrfService;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    protected $csrfService;

    public function __construct(CsrfService $csrfService)
    {
        $this->middleware('guest');
        $this->csrfService = $csrfService;
    }

    public function showLinkRequestForm()
    {
        $token = $this->csrfService->generateToken();
        return view('auth.email', ['custom_csrf_token' => $token]);
    }
}