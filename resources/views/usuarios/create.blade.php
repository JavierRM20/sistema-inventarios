@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">➕ Crear Usuario</h1>

        <form action="{{ route('usuarios.store') }}" method="POST">
            @csrf

            {{-- Mostrar errores de validación --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>⚠️ {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('usuarios.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">👤 Nombre</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">📧 Correo</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                </div>

                <div class="mb-3">
                    <label for="role" class="form-label">🔑 Rol</label>
                    <select name="role" class="form-select" required>
                        <option value="admin">Administrador</option>
                        <option value="user">Usuario</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">🔒 Contraseña</label>
                    <div class="input-group">
                        <input type="password" name="password" id="password" class="form-control" required>
                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password')">
                            👁️
                        </button>
                    </div>
                    <small class="text-muted">Mínimo 8 caracteres.</small>
                </div>

                <button type="submit" class="btn btn-success">✅ Crear Usuario</button>
                <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">⬅️ Cancelar</a>
            </form>
    </div>
@endsection