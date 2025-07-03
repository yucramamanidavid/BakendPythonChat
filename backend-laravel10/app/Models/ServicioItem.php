<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicioItem extends Model
{
    protected $fillable = [
        'servicio_id',
        'descripcion'
    ];

    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }
}
