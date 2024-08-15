<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInspeccionExtintoresTable extends Migration
{
    public function up()
    {
        Schema::create('inspeccion_extintores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas')->onDelete('cascade');
            $table->string('area');
            $table->date('fecha_inspeccion');
            $table->string('responsable_inspeccion');
            $table->string('departamento');
            $table->text('comentarios')->nullable();
            $table->text('riesgos_recomendaciones')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('inspeccion_extintores');
    }
}

