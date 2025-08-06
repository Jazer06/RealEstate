<?php

namespace App\Services;

use App\Models\CsrfToken;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CsrfService
{
    public function generateToken()
    {
        $this->clearOldToken();
        $token = Str::random(40);
        CsrfToken::create([
            'token' => $token,
            'expires_at' => Carbon::now()->addMinutes(120),
        ]);
        session()->put('custom_csrf_token', $token);
        return $token;
    }

    public function clearOldToken()
    {
        $oldToken = session('custom_csrf_token');
        if ($oldToken) {
            CsrfToken::where('token', $oldToken)->delete();
            session()->forget('custom_csrf_token');
        }
    }
}