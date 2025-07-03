<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EdificioResource extends JsonResource
{
public function toArray($request)
{
    return [
        'id' => $this->id,
        'nombre' => $this->nombre,
        'latitud' => $this->latitud,
        'longitud' => $this->longitud,
        'ubicacion_url' => $this->ubicacion_url,
    ];
}
}
