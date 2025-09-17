@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">✏️ Editar Usuario</h1>

        <form action="{{ route('usuarios.update', $usuario->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">👤 Nombre</label>
                <input type="text" name="name" class="form-control" 
                       value="{{ old('name', $usuario->name) }}" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">📧 Correo</label>
                <input type="email" name="email" class="form-control" 
                       value="{{ old('email', $usuario->email) }}" required>
            </div>

            <div class="mb-3">
                <label for="role" class="form-label">🔑 Rol</label>
                <select name="role" class="form-select" required>
                    <option value="admin" {{ $usuario->role === 'admin' ? 'selected' : '' }}>Administrador</option>
                    <option value="user" {{ $usuario->role === 'user' ? 'selected' : '' }}>Usuario</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">🔒 Nueva Contraseña (opcional)</label>
                <div class="input-group">
                    <input type="password" name="password" id="password" class="form-control">
                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password')">
                        👁️
                    </button>
                </div>
                <small class="text-muted">Déjalo vacío si no deseas cambiarla.</small>
            </div>

            <button type="submit" class="btn btn-primary">💾 Guardar Cambios</button>
            <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">⬅️ Cancelar</a>
        </form>
    </div>

    <script>
        function togglePassword(id) {
            const field = document.getElementById(id);
            field.type = field.type === 'password' ? 'text' : 'password';
        }
    </script>
@endsection
