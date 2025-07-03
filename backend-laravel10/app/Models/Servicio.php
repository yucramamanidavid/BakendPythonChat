<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $fillable = [
        'nombre',
        'horario',
        'ubicacion_url'
    ];

    public function items()
    {
        return $this->hasMany(ServicioItem::class);
    }
}
