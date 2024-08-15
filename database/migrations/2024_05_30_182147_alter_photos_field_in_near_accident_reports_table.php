<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('near_accident_reports', function (Blueprint $table) {
            // Cambia el tipo de campo 'photos' a JSON
            $table->json('photos')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('near_accident_reports', function (Blueprint $table) {
            // Revertir el campo 'photos' a tipo texto
            $table->text('photos')->nullable()->change();
        });
    }
};
