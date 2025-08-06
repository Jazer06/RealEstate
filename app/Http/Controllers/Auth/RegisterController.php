<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\CsrfService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $csrfService;

    public function __construct(CsrfService $csrfService)
    {
        $this->middleware('guest');
        $this->csrfService = $csrfService;
    }

    public function showRegistrationForm()
    {
        $token = $this->csrfService->generateToken();
        return view('auth.register', ['custom_csrf_token' => $token]);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'custom_csrf_token' => ['required'],
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'user',
        ]);
    }

    protected function redirectTo()
    {
        return auth()->user()->isAdmin() ? route('dashboard') : route('home');
    }
}