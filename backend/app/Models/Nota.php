<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    use HasFactory;

    protected $table = 'notas';

    protected $fillable = [
        'curso',
        'nota',
        'creditos',
        'estudiante_id'
    ];

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }
}
