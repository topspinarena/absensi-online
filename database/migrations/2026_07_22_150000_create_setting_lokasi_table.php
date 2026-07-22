<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('setting_lokasi', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lokasi');
            $table->string('latitude');
            $table->string('longitude');
            $table->integer('radius');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('setting_lokasi');
    }
};