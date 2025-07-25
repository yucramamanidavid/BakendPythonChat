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
Schema::create('notas', function (Blueprint $table) {
    $table->id();
    $table->foreignId('estudiante_id')->constrained()->onDelete('cascade');
    $table->foreignId('curso_id')->constrained()->onDelete('cascade');
    $table->unsignedTinyInteger('nota');
    $table->unsignedTinyInteger('creditos');
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notas');
    }
};
