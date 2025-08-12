<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class FlexibleUrl implements Rule
{
    public function passes($attribute, $value)
    {
        return preg_match('/^\/[a-zA-Z0-9\/\-_\.]*$/', $value) || 
               filter_var($value, FILTER_VALIDATE_URL); 
    }

    public function message()
    {
        return 'Поле :attribute должно быть корректным URL или относительным путем.';
    }
}