<?php

return [
    'unique' => 'Этот :attribute уже зарегистрирован.',
    'required' => 'Поле :attribute обязательно для заполнения.',
    'email' => 'Поле :attribute должно быть действительным адресом электронной почты.',
    'max' => [
        'string' => 'Поле :attribute не может быть длиннее :max символов.',
    ],
    'min' => [
        'string' => 'Поле :attribute должно содержать не менее :min символов.',
    ],
    'confirmed' => 'Поле :attribute не совпадает с подтверждением.',
    'attributes' => [
        'name' => 'имя',
        'email' => 'email',
        'password' => 'пароль',
    ],
];