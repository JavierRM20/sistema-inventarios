@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Registrar Movimiento</h1>

    <form action="{{ route('movimientos.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Producto:</label>
            <select name="producto_id" class="form-select" required>
                @foreach($productos as $producto)
                    <option value="{{ $producto->id }}">{{ $producto->nombre }} (Stock: {{ $producto->cantidad }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Tipo:</label>
            <select name="tipo" class="form-select" required>
                <option value="entrada">Entrada</option>
                <option value="salida">Salida</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Cantidad:</label>
            <input type="number" name="cantidad" class="form-control" required min="1">
        </div>

        <div class="mb-3">
            <label>Referencia:</label>
            <input type="text" name="referencia" class="form-control">
        </div>

        <div class="mb-3">
            <label>Observaciones:</label>
            <textarea name="observaciones" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-primary" onclick="this.disabled=true;this.form.submit();">💾 Guardar</button>
        <a href="{{ url()->previous() }}" class="btn btn-secondary"onclick="this.disabled=true;this.form.submit();"> ⬅️ Cancelar </a>

    </form>
</div>
@endsection
