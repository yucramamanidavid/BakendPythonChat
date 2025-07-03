<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use Illuminate\Http\Request;

class CarreraController extends Controller
{
    public function index()
    {
        return Carrera::with('facultad')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo_carrera' => 'required|string|max:20',
            'aula' => 'nullable|string',
            'coordenadas' => 'nullable|json',
            'ubicacion_url' => 'nullable|string',
            'facultad_id' => 'required|exists:facultades,id'
        ]);
        return Carrera::create($request->all());
    }

    public function show($id)
    {
        return Carrera::with('facultad')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $carrera = Carrera::findOrFail($id);
        $carrera->update($request->all());
        return $carrera;
    }

    public function destroy($id)
    {
        $carrera = Carrera::findOrFail($id);
        $carrera->delete();
        return response()->json(['message' => 'Carrera eliminada']);
    }
}
