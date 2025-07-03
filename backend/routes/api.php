<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AdminController,
    CarreraController,
    CursoController,
    EdificioController,
    EstudianteController,
    FacultadController,
    HorarioController,
    MatriculaController,
    NotaController,
    ServicioController
};
use App\Models\{User, Estudiante, Carrera, Curso, Facultad, Matricula};

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Todas las rutas de la API centralizadas y sin duplicados.
*/

# ──────────────── AUTENTICACIÓN OPCIONAL ──────────────── #
Route::middleware('auth:sanctum')->get('/user', fn (Request $r) => $r->user());

# ──────────────── CRUD BÁSICOS ──────────────── #
Route::apiResource('facultades',  FacultadController::class);
Route::apiResource('carreras',    CarreraController::class);
Route::apiResource('estudiantes', EstudianteController::class);
Route::apiResource('notas',       NotaController::class);
Route::apiResource('horarios',    HorarioController::class);
Route::apiResource('edificios',   EdificioController::class);

# ──────────────── RUTAS ADICIONALES ──────────────── #

## Estudiantes
Route::get('estudiantes/buscar/{identifier}', [EstudianteController::class, 'buscar']);

## Estadísticas globales
Route::get('estadisticas', fn () => [
    'total_estudiantes' => Estudiante::count(),
    'total_carreras'    => Carrera::count(),
    'total_facultades'  => Facultad::count(),
    'total_cursos'      => Curso::count(),      // <-- Añadido
    'total_matriculas'  => Matricula::count(),  // <-- Añadido
]);


## Servicios UPeU
Route::get('servicios',      [ServicioController::class, 'index']);
Route::get('servicios/{id}', [ServicioController::class, 'show']);
Route::post('servicios',     [ServicioController::class, 'store']);  // opcional

# ──────────────── ADMINISTRACIÓN PARA BOT ──────────────── #

## Lista de telegram_ids de admins
Route::get('admins', fn () =>
    User::whereIn('role', ['admin', 'subadmin', 'superadmin'])->pluck('telegram_id')
);

## Info de admin por Telegram ID
Route::get('admins/{telegram_id}', [AdminController::class, 'show']);

## Acciones protegidas solo para admin (requiere Sanctum + middleware personalizado)
Route::middleware(['auth:sanctum', 'role:admin'])->prefix('admin')->group(function () {
    Route::post('subadmin',        [AdminController::class, 'createSubAdmin']);
    Route::get('usuarios',         [AdminController::class, 'listarUsuarios']);
    Route::delete('usuario/{id}',  [AdminController::class, 'eliminarUsuario']);
    Route::put('usuario/{id}/rol', [AdminController::class, 'actualizarRol']);
});

# ──────────────── ENDPOINT CON TOKEN SIMPLE (ej. para bots) ──────────────── #
Route::get('bot/admins', function (Request $request) {
    if ($request->header('Authorization') !== 'Bearer TU_API_SECRET') {
        return response()->json(['error' => 'No autorizado'], 401);
    }

    return User::whereIn('role', ['admin', 'subadmin', 'superadmin'])
               ->pluck('telegram_id');
});
Route::post('/edificios', [EdificioController::class, 'store']);
Route::get('/edificios', [EdificioController::class, 'index']);
Route::apiResource('edificios', EdificioController::class);  // ✅ deja solo esta
Route::post('/cursos', [CursoController::class, 'store']);
Route::apiResource('cursos', CursoController::class);
Route::get('estudiantes/buscar/{identifier}', [EstudianteController::class, 'buscar']);
Route::apiResource('matriculas', MatriculaController::class);
Route::get('estudiantes/{id}/cursos', [MatriculaController::class, 'cursosPorEstudiante']);
Route::get('estudiantes/{id}/horario', [EstudianteController::class, 'horarioPorEstudiante']);
Route::get('estudiantes/{id}/matriculas', [EstudianteController::class, 'matriculasPorEstudiante']);
Route::get('/estudiantes/{codigo}', [EstudianteController::class, 'showPorCodigo']);
Route::get('/estudiantes/buscar/{identifier}', [EstudianteController::class, 'buscar']);
