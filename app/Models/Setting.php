<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    /**
     * Указываем имя таблицы, если оно отличается от имени модели
     */
    protected $table = 'settings';

    /**
     * Массово заполняемые поля
     */
    protected $fillable = [
        'key',
        'value',
        'type',
    ];

    /**
     * Отключаем временные метки, если они не используются
     */
    public $timestamps = true;
}