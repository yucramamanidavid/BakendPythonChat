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
Schema::create('estudiantes', function (Blueprint $table) {
    $table->id();
    $table->string('codigo_upeu')->unique();
    $table->string('dni', 8)->unique();
    $table->string('nombre');
    $table->string('email')->nullable();
    $table->string('telefono')->nullable();
    $table->foreignId('carrera_id')->constrained()->onDelete('cascade');
    $table->integer('semestre');
    $table->string('aula');
    $table->string('edificio');
    $table->string('map_url')->nullable();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estudiantes');
    }
};
