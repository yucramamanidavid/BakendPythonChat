<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    use HasFactory;

    protected $table = 'estudiantes';
    protected $fillable = [
        'codigo_upeu',
        'dni',
        'nombre',
        'email',
        'telefono',
        'semestre',
        'aula',        // ✅ añadido
        'edificio',    // ✅ añadido
        'map_url',
        'carrera_id',
    ];


    // Relación: un estudiante pertenece a una carrera
    public function carrera()
    {
        return $this->belongsTo(Carrera::class);
    }

    // Relación: un estudiante tiene muchas notas
    public function notas()
    {
        return $this->hasMany(Nota::class);
    }

    // Relación: un estudiante tiene muchos horarios
    public function horarios()
    {
        return $this->hasMany(Horario::class);
    }
    public function cursos() {
    return $this->belongsToMany(Curso::class, 'matriculas', 'alumno_id', 'curso_id')
                ->withPivot('semestre');
}
public function matriculas()
{
    return $this->hasMany(Matricula::class);
}


}
