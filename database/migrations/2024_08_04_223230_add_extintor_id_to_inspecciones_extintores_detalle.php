<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtintorIdToInspeccionesExtintoresDetalle extends Migration
{
    public function up()
    {
        Schema::table('inspecciones_extintores_detalle', function (Blueprint $table) {
            $table->foreignId('extintor_id')->after('inspeccion_extintor_id')->constrained('extintores')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('inspecciones_extintores_detalle', function (Blueprint $table) {
            $table->dropForeign(['extintor_id']);
            $table->dropColumn('extintor_id');
        });
    }
}
