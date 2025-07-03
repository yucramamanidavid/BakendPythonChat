<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cursos', function (Blueprint $table) {
            $table->integer('creditos')->nullable();
            $table->text('descripcion')->nullable();
            $table->unsignedBigInteger('facultad_id')->nullable();
            $table->string('ciclo')->nullable();
            $table->boolean('activo')->default(true);

            // Si tienes tabla facultades
            // $table->foreign('facultad_id')->references('id')->on('facultades');
        });
    }

    public function down(): void
    {
        Schema::table('cursos', function (Blueprint $table) {
            $table->dropColumn(['creditos', 'descripcion', 'facultad_id', 'ciclo', 'activo']);
            // $table->dropForeign(['facultad_id']); // si creaste la foreign key
        });
    }
};
