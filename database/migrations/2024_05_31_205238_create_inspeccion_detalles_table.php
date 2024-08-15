<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateInspeccionDetallesTable extends Migration
{
    public function up()
    {
        Schema::create('inspeccion_detalles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inspeccion_id')->constrained('inspecciones')->onDelete('cascade');
            $table->string('pregunta');
            $table->boolean('respuesta')->default(false);
            $table->text('observaciones')->nullable();
            $table->string('photo')->nullable(); // Nueva columna para la fotografía
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('inspeccion_detalles');
    }
}