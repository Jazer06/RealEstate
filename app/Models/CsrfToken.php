<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CsrfToken extends Model
{
    protected $fillable = ['token', 'expires_at'];

    public function isValid()
    {
        return now()->lessThanOrEqualTo($this->expires_at);
    }
}