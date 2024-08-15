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
        // Crear la tabla vehicle_inspections
        Schema::create('vehicle_inspections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('driver_name');
            $table->string('plate');
            $table->string('vehicle_number');
            $table->date('inspection_date');
            $table->string('supervised_by');
            $table->text('observations_general')->nullable();
            $table->timestamps();
        });

        // Crear la tabla vehicle_inspection_details
        Schema::create('vehicle_inspection_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vehicle_inspection_id');
            $table->string('question');
            $table->boolean('answer')->default(false);
            $table->text('observations')->nullable();
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
        // Eliminar la tabla vehicle_inspection_details primero debido a la clave foránea
        Schema::dropIfExists('vehicle_inspection_details');
        // Luego eliminar la tabla vehicle_inspections
        Schema::dropIfExists('vehicle_inspections');
    }
};
