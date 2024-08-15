<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('extintores', function (Blueprint $table) {
        $table->id();
        $table->string('codigo')->unique();
        $table->string('tipo'); // Cambiado a string
        $table->string('peso'); // Cambiado a string
        $table->string('area');
        $table->foreignId('empresa_id')->constrained('empresas')->onDelete('cascade');
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('extintores');
    }
};
