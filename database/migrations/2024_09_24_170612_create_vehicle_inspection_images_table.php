<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicle_inspection_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vehicle_inspection_id');
            $table->string('image_path'); // Para almacenar la ruta de la imagen
            $table->timestamps();
    
            // Definir la clave foránea
            $table->foreign('vehicle_inspection_id')->references('id')->on('vehicle_inspections')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_inspection_images');
    }
};
