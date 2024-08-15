<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrosCharlasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registros_charlas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('departamento');
            $table->string('responsable_area');
            $table->string('responsable_charla');
            $table->string('area');
            $table->date('fecha_charla');
            $table->json('tema_brindado');
            $table->text('temas_discutidos_notas');
            $table->json('fotos')->nullable();
            $table->timestamps();
        });

        // Pivot table for trabajadores and registros_charlas
        Schema::create('registro_charla_trabajador', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registro_charla_id')->constrained('registros_charlas')->onDelete('cascade');
            $table->foreignId('trabajador_id')->constrained('trabajadores')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('registro_charla_trabajador');
        Schema::dropIfExists('registros_charlas');
    }
}
