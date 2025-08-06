<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('csrf_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('token', 100)->unique();
            $table->timestamp('expires_at');
            $table->timestamps(); // created_at и updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('csrf_tokens');
    }
};
