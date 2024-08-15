<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('inspecciones_extintores_imagenes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inspeccion_extintor_id')->constrained('inspeccion_extintor')->onDelete('cascade');
            $table->foreignId('extintor_id')->constrained('extintores')->onDelete('cascade');
            $table->string('ruta_imagen');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('inspecciones_extintores_imagenes');
    }
};
