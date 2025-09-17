<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('slider_images', function (Blueprint $table) {
            $table->boolean('is_construction')->default(false)->after('image_path');
        });
    }

    public function down()
    {
        Schema::table('slider_images', function (Blueprint $table) {
            $table->dropColumn('is_construction');
        });
    }
};
