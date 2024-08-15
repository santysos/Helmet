<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInspeccionExtintorTable extends Migration
{
    public function up()
    {
        Schema::create('inspeccion_extintor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inspeccion_id')->constrained('inspeccion_extintores')->onDelete('cascade');
            $table->foreignId('extintor_id')->constrained('extintores')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('inspeccion_extintor');
    }
}
