<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'codigo',
        'creditos',
        'descripcion',
        'facultad_id',
        'ciclo',
        'activo',
    ];

    // Relación: un curso puede tener muchos horarios
    public function horarios()
    {
        return $this->hasMany(Horario::class);
    }

    // Relación: si el curso pertenece a una facultad
    public function facultad()
    {
        return $this->belongsTo(Facultad::class, 'facultad_id');
    }public function estudiantes()
{
    return $this->belongsToMany(Estudiante::class, 'matriculas');
}

}
