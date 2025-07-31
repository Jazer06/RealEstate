<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id(); // BIGINT(20) UNSIGNED AUTO_INCREMENT
            $table->string('name'); // VARCHAR(255)
            $table->string('phone', 20); // VARCHAR(20) для телефона
            $table->text('description')->nullable(); // TEXT, опционально
            $table->timestamps(); // created_at и updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
