<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    /**
     * Lista todos los servicios con sus ítems.
     */
    public function index()
    {
        return Servicio::with('items')->get();
    }

    /**
     * Muestra un servicio específico.
     */
    public function show($id)
    {
        return Servicio::with('items')->findOrFail($id);
    }

    /**
     * Crea un nuevo servicio.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'horario' => 'required|string',
            'ubicacion_url' => 'required|url',
            'items' => 'nullable|array',
            'items.*' => 'string'
        ]);

        $servicio = Servicio::create($request->only(['nombre', 'horario', 'ubicacion_url']));

        if ($request->has('items')) {
            foreach ($request->items as $descripcion) {
                $servicio->items()->create(['descripcion' => $descripcion]);
            }
        }

        return response()->json($servicio->load('items'), 201);
    }
}
