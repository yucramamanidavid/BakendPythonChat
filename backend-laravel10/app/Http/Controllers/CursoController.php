<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    // Listar todos los cursos
    public function index()
    {
        // Incluye la facultad y los horarios si quieres
        return Curso::with(['facultad', 'horarios'])->get();
    }

    // Crear un nuevo curso
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre'      => 'required|string|max:255',
            'codigo'      => 'nullable|string|max:20',
            'creditos'    => 'nullable|integer|min:0',
            'descripcion' => 'nullable|string',
            'facultad_id' => 'nullable|exists:facultades,id',
            'ciclo'       => 'nullable|string|max:10',
            'activo'      => 'boolean',
        ]);

        $curso = Curso::create($validated);

        return response()->json($curso, 201);
    }

    // Mostrar un curso específico
    public function show($id)
    {
        $curso = Curso::with(['facultad', 'horarios'])->findOrFail($id);
        return response()->json($curso);
    }

    // Actualizar un curso
    public function update(Request $request, $id)
    {
        $curso = Curso::findOrFail($id);

        $validated = $request->validate([
            'nombre'      => 'sometimes|required|string|max:255',
            'codigo'      => 'nullable|string|max:20',
            'creditos'    => 'nullable|integer|min:0',
            'descripcion' => 'nullable|string',
            'facultad_id' => 'nullable|exists:facultades,id',
            'ciclo'       => 'nullable|string|max:10',
            'activo'      => 'boolean',
        ]);

        $curso->update($validated);

        return response()->json($curso);
    }

    // Eliminar un curso
    public function destroy($id)
    {
        $curso = Curso::findOrFail($id);
        $curso->delete();
        return response()->json(['message' => 'Curso eliminado correctamente']);
    }
}
