<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\CsrfToken;

class CustomCsrf
{
    public function handle($request, Closure $next)
    {
        CsrfToken::where('expires_at', '<', now())->delete();

        $token = $request->input('custom_csrf_token');
        if (!$token) {
            return response('Page Expired: CSRF token missing.', 419);
        }

        $dbToken = CsrfToken::where('token', $token)->first();
        if (!$dbToken || !$dbToken->isValid()) {
            if ($dbToken) {
                $dbToken->delete();
            }
            return response('Page Expired: Invalid or expired CSRF token.', 419);
        }

        $dbToken->delete();
        return $next($request);
    }
}