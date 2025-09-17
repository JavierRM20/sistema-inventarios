@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4 text-center">👥 Lista de Usuarios</h1>

    {{-- Mensajes de éxito o error --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Botón Crear Usuario (solo admin) --}}
    @if(auth()->user()->role === 'admin')
        <div class="mb-3 text-end">
            <a href="{{ route('usuarios.create') }}" class="btn btn-success">➕ Crear Usuario</a>
        </div>
    @endif

    {{-- Tabla de usuarios --}}
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Rol</th>
                @if(auth()->user()->role === 'admin')
                    <th>Acciones</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse($usuarios as $usuario)
                <tr>
                    <td>{{ $usuario->name }}</td>
                    <td>{{ $usuario->email }}</td>
                    <td>
                        @if($usuario->role === 'admin')
                            🛡️ Admin
                        @else
                            👤 Usuario
                        @endif
                    </td>
                    @if(auth()->user()->role === 'admin')
                        <td>
                            <a href="{{ route('usuarios.edit', $usuario->id) }}" class="btn btn-warning btn-sm">✏️ Editar</a>
                            <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar este usuario?')">🗑️ Eliminar</button>
                            </form>
                        </td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="{{ auth()->user()->role === 'admin' ? 4 : 3 }}" class="text-center">⚠️ No se encontraron usuarios.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
