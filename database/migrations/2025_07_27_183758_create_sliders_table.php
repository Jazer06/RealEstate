<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
        {
            Schema::create('sliders', function (Blueprint $table) {
                $table->id();
                $table->string('title')->nullable(); // Заголовок слайда (например, "CITYZEN")
                $table->string('subtitle')->nullable(); // Подпись (например, "Распродажа с первым взносом от 640 тыс. Р.")
                $table->string('button_text')->nullable(); // Текст кнопки (например, "Подробнее")
                $table->string('button_link')->nullable(); // Ссылка кнопки (например, "https://example.com/slide1")
                $table->string('image_path')->nullable(); // Путь к изображению
                $table->timestamps();
            });
        }

        public function down(): void
        {
            Schema::dropIfExists('sliders');
        }
};
