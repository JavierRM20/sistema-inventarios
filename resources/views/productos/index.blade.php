@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4 text-center">📋 Lista de Productos</h1>

    {{-- Barra de búsqueda --}}
    <form method="GET" action="{{ route('productos.index') }}" class="row g-3 mb-4 align-items-center">
        <div class="col-md-6">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Buscar por nombre o código...">
        </div>

        {{-- Botones de búsqueda y limpiar --}}
        <div class="col-md-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary">🔍 Buscar</button>
            <a href="{{ route('productos.index') }}" class="btn btn-secondary">🧹 Limpiar</a>
        </div>

        {{-- Botón nuevo producto --}}
        <div class="col-md-2 text-end">
            <a href="{{ route('productos.create') }}" class="btn btn-success w-100">➕ Nuevo Producto</a>
        </div>
    </form>

    {{-- Mensajes de éxito --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Tabla de productos --}}
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Nombre</th>
                <th>Código</th>
                <th>Cantidad</th>
                <th>Precio Compra</th>
                <th>Precio Venta</th>
                <th>Stock Mínimo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($productos as $producto)
                <tr @if($producto->cantidad <= $producto->min_stock) class="table-warning" @endif>
                    <td>{{ $producto->nombre }}</td>
                    <td>{{ $producto->codigo }}</td>
                    <td>
                        {{ $producto->cantidad }}
                        @if($producto->cantidad <= $producto->min_stock)
                            <span class="badge bg-danger ms-2">⚠ Bajo Stock</span>
                        @endif
                    </td>
                    <td>${{ number_format($producto->precio_compra, 0, ',', '.') }}</td>
                    <td>${{ number_format($producto->precio_venta, 0, ',', '.') }}</td>
                    <td>{{ $producto->min_stock }}</td>
                    <td class="text-center">
                        <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-warning btn-sm">✏️ Editar</a>
                        <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar este producto?')">🗑️ Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">⚠️ No se encontraron productos.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Paginación --}}
    <div class="d-flex justify-content-center">
        {{ $productos->links() }}
    </div>
</div>
@endsection
