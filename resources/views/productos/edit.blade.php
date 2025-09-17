@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">✏️ Editar Producto</h1>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('productos.update', $producto->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="nombre" class="form-label">📦 Nombre del producto</label>
                        <input type="text" 
                               class="form-control @error('nombre') is-invalid @enderror" 
                               id="nombre"
                               name="nombre" 
                               value="{{ old('nombre', $producto->nombre) }}" 
                               required>
                        @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="codigo" class="form-label">🔢 Código</label>
                        <input type="text" 
                               class="form-control @error('codigo') is-invalid @enderror" 
                               id="codigo"
                               name="codigo" 
                               value="{{ old('codigo', $producto->codigo) }}" 
                               required>
                        @error('codigo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="cantidad" class="form-label">📊 Cantidad</label>
                        <input type="number" 
                               class="form-control @error('cantidad') is-invalid @enderror" 
                               id="cantidad"
                               name="cantidad" 
                               value="{{ old('cantidad', $producto->cantidad) }}" 
                               min="0" 
                               required>
                        @error('cantidad')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="precio_compra" class="form-label">💰 Precio de Compra</label>
                        <input type="number" 
                               step="0.01" 
                               name="precio_compra" 
                               class="form-control @error('precio_compra') is-invalid @enderror"
                               value="{{ old('precio_compra', $producto->precio_compra) }}" 
                               required>
                        @error('precio_compra')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="precio_venta" class="form-label">💵 Precio de Venta</label>
                        <input type="number" 
                               step="0.01" 
                               name="precio_venta" 
                               class="form-control @error('precio_venta') is-invalid @enderror"
                               value="{{ old('precio_venta', $producto->precio_venta) }}" 
                               required>
                        @error('precio_venta')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="min_stock" class="form-label">⚠️ Stock Mínimo</label>
                        <input type="number" 
                               name="min_stock" 
                               class="form-control @error('min_stock') is-invalid @enderror"
                               value="{{ old('min_stock', $producto->min_stock) }}" 
                               required>
                        @error('min_stock')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('productos.index') }}" class="btn btn-secondary">⬅ Volver</a>
                        <button type="submit" class="btn btn-primary">💾 Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
