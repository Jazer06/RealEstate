<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->unsignedBigInteger('slider_id')->nullable()->after('user_id');
            $table->foreign('slider_id')->references('id')->on('sliders')->onDelete('set null');
        });
    }
    
    public function down()
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropForeign(['slider_id']);
            $table->dropColumn('slider_id');
        });
    }
};
