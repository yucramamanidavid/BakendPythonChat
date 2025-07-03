<?php

namespace App\Http\Controllers;

use App\Models\Matricula;
use Illuminate\Http\Request;

class MatriculaController extends Controller
{
    // Listar todas las matrículas
    public function index()
    {
        return Matricula::with(['estudiante', 'curso'])->get();
    }

    // Mostrar una matrícula específica
    public function show($id)
    {
        return Matricula::with(['estudiante', 'curso'])->findOrFail($id);
    }

    // Registrar una nueva matrícula
    public function store(Request $request)
    {
        $validated = $request->validate([
            'estudiante_id' => 'required|exists:estudiantes,id',
            'curso_id'      => 'required|exists:cursos,id',
            'semestre'      => 'required|string',
        ]);

        $matricula = Matricula::create($validated);
        return response()->json($matricula->load(['estudiante', 'curso']), 201);
    }

    // Actualizar una matrícula existente
    public function update(Request $request, $id)
    {
        $matricula = Matricula::findOrFail($id);

        $validated = $request->validate([
            'estudiante_id' => 'sometimes|exists:estudiantes,id',
            'curso_id'      => 'sometimes|exists:cursos,id',
            'semestre'      => 'sometimes|string',
        ]);

        $matricula->update($validated);
        return response()->json($matricula->load(['estudiante', 'curso']));
    }

    // Eliminar una matrícula
    public function destroy($id)
    {
        $matricula = Matricula::findOrFail($id);
        $matricula->delete();

        return response()->json(['message' => 'Matrícula eliminada']);
    }
    // MatriculaController.php
public function cursosPorEstudiante($estudiante_id)
{
    $matriculas = Matricula::with('curso')
        ->where('estudiante_id', $estudiante_id)
        ->get();

    return response()->json($matriculas);
}

}
