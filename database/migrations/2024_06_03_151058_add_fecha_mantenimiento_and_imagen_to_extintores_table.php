<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFechaMantenimientoAndImagenToExtintoresTable extends Migration
{
    public function up()
    {
        Schema::table('extintores', function (Blueprint $table) {
            $table->date('fecha_mantenimiento')->nullable();
            $table->string('imagen')->nullable();
        });
    }

    public function down()
    {
        Schema::table('extintores', function (Blueprint $table) {
            $table->dropColumn('fecha_mantenimiento');
            $table->dropColumn('imagen');
        });
    }
}
