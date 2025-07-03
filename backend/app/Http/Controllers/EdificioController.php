<?php

namespace App\Http\Controllers;

use App\Models\Edificio;
use Illuminate\Http\Request;

class EdificioController extends Controller
{
    public function index()
    {
        return Edificio::all();
    }

public function store(Request $request)
{
    $request->validate([
        'nombre' => 'required|string|max:100',
        'latitud' => 'nullable|numeric',
        'longitud' => 'nullable|numeric',
        'ubicacion_url' => 'nullable|string|url',
    ]);

    $edificio = Edificio::create([
        'nombre' => $request->nombre,
        'latitud' => $request->latitud,
        'longitud' => $request->longitud,
        'ubicacion_url' => $request->ubicacion_url,
    ]);

    return response()->json([
        'message' => 'Edificio creado exitosamente',
        'data' => $edificio
    ], 201);
}


}
