<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    Schema::table('edificios', function (Blueprint $table) {
        $table->decimal('latitud', 10, 8)->nullable();
        $table->decimal('longitud', 11, 8)->nullable();
        $table->string('ubicacion_url')->nullable();
    });
}

public function down(): void
{
    Schema::table('edificios', function (Blueprint $table) {
        $table->dropColumn(['latitud', 'longitud', 'ubicacion_url']);
    });
}

};
