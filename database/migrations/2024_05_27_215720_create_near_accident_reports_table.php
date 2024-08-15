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
        Schema::create('near_accident_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('reporter_name');
            $table->string('reporter_position');
            $table->string('reporter_area');
            $table->string('victim_name');
            $table->string('victim_position');
            $table->string('victim_work_location');
            $table->text('description');
            $table->string('condition_type');
            $table->string('severity_level');
            $table->text('photos')->nullable();
            $table->string('follow_up_name');
            $table->string('follow_up_email');
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('near_accident_reports');
    }
};
