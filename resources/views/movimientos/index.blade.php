@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Historial de Movimientos (Kardex)</h1>

        {{-- Alertas --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Botones principales --}}
        <div class="mb-3 d-flex justify-content-start">
            <a href="{{ route('movimientos.create') }}" class="btn btn-primary me-2">
                Registrar Movimiento
            </a>
            <a href="{{ route('productos.index') }}" class="btn btn-secondary">
                Volver a Productos
            </a>
        </div>

        {{-- Contenedor para los botones de exportación --}}
        <div class="mb-3 d-flex gap-2" id="exportButtons"></div>

        {{-- Tabla Kardex --}}
        <table id="movimientosTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Producto</th>
                    <th>Tipo</th>
                    <th>Cantidad</th>
                    <th>Referencia</th>
                    <th>Observaciones</th>
                    <th>Usuario</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                @foreach($movimientos as $mov)
                    <tr>
                        <td>{{ $mov->id }}</td>
                        <td>{{ $mov->producto->nombre }}</td>
                        <td>
                            @if($mov->tipo == 'entrada')
                                <span class="badge bg-success">Entrada</span>
                            @else
                                <span class="badge bg-danger">Salida</span>
                            @endif
                        </td>
                        <td>{{ $mov->cantidad }}</td>
                        <td>{{ $mov->referencia ?? '-' }}</td>
                        <td>{{ $mov->observaciones ?? '-' }}</td>
                        <td>{{ $mov->user->name ?? 'N/A' }}</td>
                        <td>{{ $mov->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        var table = $('#movimientosTable').DataTable({
            order: [[0, "desc"]],
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
            },
            dom: 'Bfrtip', // 👈 crea los botones
            buttons: [
                {
                    extend: 'copy',
                    text: '<i class="bi bi-clipboard"></i> Copiar',
                    className: 'btn btn-dark'
                },
                {
                    extend: 'excelHtml5',
                    text: '<i class="bi bi-file-earmark-excel"></i> Excel',
                    className: 'btn btn-success'
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="bi bi-file-earmark-pdf"></i> PDF',
                    className: 'btn btn-danger',
                    title: 'Kardex - Sistema de Inventarios',
                },
                {
                    extend: 'print',
                    text: '<i class="bi bi-printer"></i> Imprimir',
                    className: 'btn btn-primary'
                }
            ]
        });

        // 👇 Mueve los botones al contenedor
        table.buttons().container().appendTo('#exportButtons');
    });
</script>
@endpush
