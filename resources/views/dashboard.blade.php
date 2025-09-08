@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-bold mb-4">
    Hola, {{ Auth::user()->name }} 👋 Bienvenido de nuevo
</h1>
<p class="text-gray-600">
    Tu correo es: {{ Auth::user()->email }}
</p>
    
<div class="container">
    <h1 class="mb-4">📊 Dashboard del Inventario</h1>

    {{-- Métricas rápidas --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-bg-primary shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">📦 Total Productos</h5>
                    <h2>{{ $totalProductos }}</h2>
                    <p class="card-text">Productos registrados en el inventario.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-bg-success shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">📥 Stock Total</h5>
                    <h2>{{ $stockTotal }}</h2>
                    <p class="card-text">Unidades disponibles en inventario.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-bg-warning shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">💰 Valor Total</h5>
                    <h2>${{ number_format($valorTotal, 0, ',', '.') }}</h2>
                    <p class="card-text">Valor acumulado del inventario.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Accesos rápidos --}}
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <h5 class="card-title">📋 Productos</h5>
                    <p class="card-text">Gestiona los productos de tu inventario.</p>
                    <a href="{{ route('productos.index') }}" class="btn btn-primary">Ver productos</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <h5 class="card-title">👥 Usuarios</h5>
                    <p class="card-text">Administra los usuarios del sistema.</p>
                    <a href="#" class="btn btn-success">Ver usuarios</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <h5 class="card-title">📑 Reportes</h5>
                    <p class="card-text">Visualiza reportes del inventario.</p>
                    <a href="#" class="btn btn-warning">Ver reportes</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
