<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EstudianteResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'       => $this->id,
            'codigo'   => $this->codigo_upeu,
            'dni'      => $this->dni,
            'name'     => $this->nombre,
            'phone'    => $this->telefono,
            'email'    => $this->email,
            'semester' => $this->semestre,
            'aula'     => $this->aula,
            'edificio' => $this->edificio,
            'map_url'  => $this->map_url,

            'career' => [
                'id'             => $this->carrera_id,
                'nombre'         => $this->carrera->nombre ?? null,
                'aula'           => $this->carrera->aula ?? null,
                'codigo_carrera' => $this->carrera->codigo_carrera ?? null,
                'lat'            => $this->carrera->latitud ?? null,
                'lon'            => $this->carrera->longitud ?? null,
                'ubicacion_url'  => $this->carrera->ubicacion_url ?? null,
                'facultad'       => $this->carrera->facultad->nombre ?? null,
            ],

            'schedule' => $this->horarios->map(function ($h) {
                return [
                    'día'      => $h->dia,
                    'curso'    => $h->curso,
                    'hora'     => $h->hora,
                    'profesor' => $h->profesor ?? 'Por asignar',
                ];
            }),

            'grades' => $this->notas->map(function ($n) {
                return [
                    'curso'    => $n->curso,
                    'nota'     => $n->nota,
                    'creditos' => $n->creditos,
                ];
            }),
        ];
    }
}
