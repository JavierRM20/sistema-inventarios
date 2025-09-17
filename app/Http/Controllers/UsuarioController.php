<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = User::all();
        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('usuarios.index')->with('error', '⚠️ No tienes permisos para crear usuarios.');
        }

        return view('usuarios.create');
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('usuarios.index')->with('error', '⚠️ No tienes permisos para crear usuarios.');
        }

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'role'     => 'required|string|in:admin,user',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'role'     => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('usuarios.index')->with('success', '✅ Usuario creado correctamente.');
    }

    public function edit(User $usuario)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('usuarios.index')->with('error', '⚠️ No tienes permisos para editar usuarios.');
        }

        return view('usuarios.edit', compact('usuario'));
    }

public function update(Request $request, User $usuario)
{
    if (auth()->user()->role !== 'admin') {
        return redirect()->route('usuarios.index')->with('error', '⚠️ No tienes permisos para actualizar usuarios.');
    }

    $request->validate([
        'name'  => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $usuario->id,
        'role'  => 'required|string|in:admin,user',
        'password' => 'nullable|string|min:6', // 🔑 ahora es opcional
    ]);

    // Actualizamos los campos básicos
    $usuario->name = $request->name;
    $usuario->email = $request->email;
    $usuario->role = $request->role;

    // Solo si el campo password tiene algo lo actualizamos
    if ($request->filled('password')) {
        $usuario->password = Hash::make($request->password);
    }

    $usuario->save();

    return redirect()->route('usuarios.index')->with('success', '✅ Usuario actualizado correctamente.');
}

    public function destroy(User $usuario)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('usuarios.index')->with('error', '⚠️ No tienes permisos para eliminar usuarios.');
        }

        $usuario->delete();

        return redirect()->route('usuarios.index')->with('success', '🗑️ Usuario eliminado correctamente.');
    }
}
