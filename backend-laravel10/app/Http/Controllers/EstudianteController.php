<?php

namespace App\Http\Controllers;

use App\Http\Resources\EstudianteResource;
use App\Models\Estudiante;
use App\Models\Horario;
use App\Models\Matricula;
use Illuminate\Http\Request;

class EstudianteController extends Controller
{
    // 🔍 Obtener todos los estudiantes
    public function index()
    {
        $estudiantes = Estudiante::with(['carrera.facultad', 'notas', 'horarios'])->get();
        return EstudianteResource::collection($estudiantes);
    }

    // 📝 Crear un nuevo estudiante
    public function store(Request $request)
    {
        $request->validate([
            'codigo_upeu' => 'required|string|max:20|unique:estudiantes,codigo_upeu',
            'dni'         => 'required|string|size:8|unique:estudiantes,dni',
            'nombre'      => 'required|string|max:255',
            'email'       => 'nullable|email',
            'telefono'    => 'nullable|string',
            'semestre'    => 'required|integer',
            'aula'        => 'required|string',
            'edificio'    => 'required|string',
            'map_url'     => 'nullable|string',
            'carrera_id'  => 'required|exists:carreras,id'
        ]);

        try {
            $estudiante = Estudiante::create($request->only([
                'codigo_upeu', 'dni', 'nombre', 'email', 'telefono',
                'semestre', 'aula', 'edificio', 'map_url', 'carrera_id'
            ]));

            return response()->json(new EstudianteResource($estudiante), 201);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // 🔎 Ver un estudiante por ID
    public function show($id)
    {
        $est = Estudiante::with(['carrera.facultad', 'notas', 'horarios','matriculas.curso'])
            ->where('id', $id)
            ->orWhere('codigo_upeu', $id)
            ->firstOrFail();
        return new EstudianteResource($est);
    }


    // ✏️ Actualizar estudiante
    public function update(Request $request, $id)
    {
        $estudiante = Estudiante::findOrFail($id);
        $estudiante->update($request->all());
        return new EstudianteResource($estudiante);
    }

    // 🗑️ Eliminar estudiante
    public function destroy($id)
    {
        $estudiante = Estudiante::findOrFail($id);
        $estudiante->delete();
        return response()->json(['message' => 'Estudiante eliminado']);
    }

    // 🔍 Buscar por código UPeU o DNI
    // En EstudianteController.php
    public function buscar($identifier)
    {
        $est = Estudiante::with(['carrera.facultad', 'notas', 'matriculas.curso'])
            ->where('codigo_upeu', $identifier)
            ->orWhere('dni', $identifier)
            ->first();

        if (!$est) {
            return response()->json(['error' => 'Estudiante no encontrado'], 404);
        }

        // Trae los horarios de los cursos matriculados
        $horarios = [];
        foreach ($est->matriculas as $mat) {
            $curso = $mat->curso;
            if ($curso) {
                $hs = Horario::where('curso_id', $curso->id)
                    ->where('estudiante_id', $est->id)  // Quita esto si el horario es por curso y no por alumno
                    ->get();

                foreach ($hs as $h) {
                    $horarios[] = [
                        'dia'      => $h->dia,
                        'hora'     => $h->hora,
                        'curso'    => $curso->nombre,
                        'profesor' => $h->profesor,
                    ];
                }
            }
        }

        // Las notas igual puedes traerlas así:
        $grades = $est->notas->map(function ($nota) {
            return [
                'curso'    => $nota->curso->nombre ?? '',
                'nota'     => $nota->nota,
                'creditos' => $nota->creditos,
            ];
        });

        return response()->json([
            'id'        => $est->id,
            'codigo_upeu' => $est->codigo_upeu,
            'name'      => $est->nombre,
            'career'    => $est->carrera,
            'aula'      => $est->aula,
            'edificio'  => $est->edificio,
            'semester'  => $est->semestre,
            'phone'     => $est->telefono,
            'map_url'   => $est->map_url,
            'grades'    => $grades,
            'schedule'  => $horarios,  // <---- Esto leerá tu horario en el bot
        ]);
    }

    // en EstudianteController.php
public function horario($id)
{
    $estudiante = Estudiante::findOrFail($id);

    // Cursos que lleva el alumno este semestre
    $matriculas = $estudiante->matriculas()->with('curso')->get();

    $horarios = [];
    foreach($matriculas as $matricula){
        $curso = $matricula->curso;
        $horario = Horario::where('curso_id', $curso->id)
                    ->where('estudiante_id', $estudiante->id) // o solo por curso si los horarios son generales
                    ->get();
        foreach($horario as $h){
            $horarios[] = [
                'dia'      => $h->dia,
                'hora'     => $h->hora,
                'curso'    => $curso->nombre,
                'aula'     => $h->aula ?? null,
                'profesor' => $h->profesor ?? null,
            ];
        }
    }

    return response()->json($horarios);
}
// En EstudianteController.php o MatriculaController.php
public function horarioPorEstudiante($estudiante_id)
{
    // Obtiene todos los horarios de los cursos en los que está matriculado el estudiante
    $horarios = Horario::with('curso')
        ->where('estudiante_id', $estudiante_id)
        ->get();

    return response()->json($horarios);
}

public function matriculasPorEstudiante($id)
{
    // Devuelve las matrículas del estudiante, junto con info de curso
    $matriculas = Matricula::with('curso')->where('estudiante_id', $id)->get();
    return response()->json($matriculas);
}

}
