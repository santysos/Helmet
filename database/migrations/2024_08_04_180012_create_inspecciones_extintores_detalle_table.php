<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInspeccionesExtintoresDetalleTable extends Migration
{
    public function up()
    {
        Schema::create('inspecciones_extintores_detalle', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inspeccion_extintor_id')->constrained('inspeccion_extintores')->onDelete('cascade');
            $table->string('pregunta');
            $table->enum('respuesta', ['si', 'no']);
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('inspecciones_extintores_detalle');
    }
}

