<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matricula extends Model
{
    use HasFactory;
 public $timestamps = false;
    protected $table = 'matriculas';

    protected $fillable = [
        'estudiante_id',
        'curso_id',
        'semestre',
    ];

    // Relación: una matrícula pertenece a un estudiante
    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }

    // Relación: una matrícula pertenece a un curso
    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }
}
