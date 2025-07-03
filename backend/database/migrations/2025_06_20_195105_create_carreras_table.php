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
Schema::create('carreras', function (Blueprint $table) {
    $table->id();
    $table->foreignId('facultad_id')->constrained('facultades')->onDelete('cascade');

    $table->string('nombre');
    $table->string('codigo_carrera')->unique();
    $table->string('aula');
    $table->decimal('latitud', 10, 7)->nullable();
    $table->decimal('longitud', 10, 7)->nullable();
    $table->string('ubicacion_url')->nullable();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carreras');
    }
};
