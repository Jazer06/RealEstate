<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->float('area')->nullable()->after('price'); // Площадь в кв.м
            $table->integer('rooms')->nullable()->after('area'); // Количество комнат
            $table->string('type')->nullable()->after('rooms'); // Тип недвижимости (квартира, дом и т.д.)
            $table->renameColumn('image', 'image_path'); // Переименовываем image в image_path для консистентности
        });
    }

    public function down()
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn(['area', 'rooms', 'type']);
            $table->renameColumn('image_path', 'image');
        });
    }
};
