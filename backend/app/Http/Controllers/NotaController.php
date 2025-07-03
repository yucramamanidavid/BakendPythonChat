<?php

namespace App\Http\Controllers;

use App\Models\Nota;
use Illuminate\Http\Request;

class NotaController extends Controller
{
    public function index()
    {
        return Nota::with('estudiante')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'curso' => 'required|string|max:255',
            'nota' => 'required|numeric',
            'creditos' => 'required|numeric',
            'estudiante_id' => 'required|exists:estudiantes,id'
        ]);
        return Nota::create($request->all());
    }

    public function show($id)
    {
        return Nota::with('estudiante')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $nota = Nota::findOrFail($id);
        $nota->update($request->all());
        return $nota;
    }

    public function destroy($id)
    {
        $nota = Nota::findOrFail($id);
        $nota->delete();
        return response()->json(['message' => 'Nota eliminada']);
    }
}

