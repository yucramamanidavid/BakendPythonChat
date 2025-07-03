<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // Crear subadmin
    public function createSubAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'subadmin',
        ]);

        return response()->json([
            'message' => '✅ Subadmin creado correctamente',
            'user' => $user
        ], 201);
    }

    // Listar todos los usuarios (solo si eres admin)
    public function listarUsuarios()
    {
        $usuarios = User::select('id', 'name', 'email', 'role', 'created_at')->get();

        return response()->json([
            'total' => $usuarios->count(),
            'usuarios' => $usuarios
        ]);
    }

    // Eliminar un subadmin
    public function eliminarUsuario($id)
    {
        $usuario = User::findOrFail($id);

        if ($usuario->role !== 'subadmin') {
            return response()->json(['error' => 'Solo puedes eliminar subadmins'], 403);
        }

        $usuario->delete();

        return response()->json(['message' => '🗑️ Subadmin eliminado correctamente']);
    }

    // Cambiar rol (admin <-> subadmin)
    public function actualizarRol(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:admin,subadmin'
        ]);

        $usuario = User::findOrFail($id);
        $usuario->role = $request->role;
        $usuario->save();

        return response()->json(['message' => '✅ Rol actualizado correctamente', 'user' => $usuario]);
    }
    public function isAdmin($telegram_id)
{
    $user = User::where('telegram_id', $telegram_id)->first();

    if (!$user) {
        return response()->json(['is_admin' => false]);
    }

    return response()->json([
        'is_admin' => in_array($user->role, ['admin', 'subadmin', 'superadmin'])
    ]);
}
public function show($telegram_id)
{
    $user = User::where('telegram_id', $telegram_id)->first();

    if (!$user || !in_array($user->role, ['admin','subadmin','superadmin'])) {
        return response()->json(['error' => 'No autorizado'], 403);
    }

    return response()->json([
        'name' => $user->name,
        'role' => $user->role,
        'telegram_id' => $user->telegram_id
    ]);
}


}
