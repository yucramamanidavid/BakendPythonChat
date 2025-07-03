<?php

namespace App\Http\Controllers;

use App\Models\Facultad;
use Illuminate\Http\Request;

class FacultadController extends Controller
{
public function index()
{
    return Facultad::with('carreras')->get();
}


    public function store(Request $request)
    {
        $request->validate(['nombre' => 'required|string|max:255']);
        return Facultad::create($request->only('nombre'));
    }

    public function show($id)
    {
        return Facultad::with('carreras')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $facultad = Facultad::findOrFail($id);
        $facultad->update($request->only('nombre'));
        return $facultad;
    }

    public function destroy($id)
    {
        $facultad = Facultad::findOrFail($id);
        $facultad->delete();
        return response()->json(['message' => 'Facultad eliminada']);
    }
}
