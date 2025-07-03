<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    use HasFactory;

    protected $table = 'carreras';

    protected $fillable = [
        'nombre',
        'codigo_carrera',
        'aula',
        'ubicacion_url',
        'facultad_id',
        'lat',
        'lon'
    ];

    // Relación: muchas carreras pertenecen a una facultad
    public function facultad()
    {
        return $this->belongsTo(Facultad::class);
    }

    // Relación con estudiantes (si agregas ese modelo luego)
    public function estudiantes()
    {
        return $this->hasMany(Estudiante::class);
    }
}
