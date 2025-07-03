<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    public function index()
    {
        return Horario::with('estudiante')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'curso' => 'required|string|max:255',
            'hora' => 'required|string',
            'dia' => 'required|string',
            'profesor' => 'nullable|string',
            'estudiante_id' => 'required|exists:estudiantes,id'
        ]);
        return Horario::create($request->all());
    }

    public function show($id)
    {
        return Horario::with('estudiante')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $horario = Horario::findOrFail($id);
        $horario->update($request->all());
        return $horario;
    }

    public function destroy($id)
    {
        $horario = Horario::findOrFail($id);
        $horario->delete();
        return response()->json(['message' => 'Horario eliminado']);
    }
}
