<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory;

    protected $table = 'horarios';

    protected $fillable = [
        'día',
        'curso',
        'hora',
        'profesor',
        'estudiante_id'
    ];

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }
}
