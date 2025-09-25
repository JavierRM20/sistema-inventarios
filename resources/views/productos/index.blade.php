@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4 text-center">📋 Lista de Productos</h1>

        {{-- Botón nuevo producto --}}
        <div class="mb-3 text-end">
            <a href="{{ route('productos.create') }}" class="btn btn-success">➕ Nuevo Producto</a>
        </div>
        {{-- Botón registrar movimiento --}}
        <div class="text-end">
            <a href="{{ route('movimientos.create') }}" class="btn btn-primary mb-3">➕ Registrar Movimiento</a>
        </div>
        {{-- Mensajes de éxito --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- Tabla de productos con DataTables --}}
        <table id="productosTable" class="table table-bordered table-striped">
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
                            <form action="{{ route('productos.destroy', $producto->id) }}" method="POST"
                                style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('¿Seguro que deseas eliminar este producto?')">🗑️ Eliminar</button>
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
    </div>
@endsection

@push('scripts')
    {{-- JS de DataTables y extensiones --}}
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    {{-- Plugin para ordenar de forma natural --}}
    <script>
        jQuery.extend(jQuery.fn.dataTableExt.oSort, {
            "natural-asc": function (a, b) {
                return a.localeCompare(b, undefined, { numeric: true, sensitivity: 'base' });
            },
            "natural-desc": function (a, b) {
                return b.localeCompare(a, undefined, { numeric: true, sensitivity: 'base' });
            }
        });
    </script>

    <script>
        $(document).ready(function () {
            $('#productosTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
                    search: "🔍 Buscar referencias:",
                    lengthMenu: "Mostrar _MENU_ registros por página",
                    info: "Mostrando _START_ a _END_ de _TOTAL_ productos",
                    infoEmpty: "Mostrando 0 a 0 de 0 productos",
                    infoFiltered: "(filtrado de _MAX_ productos en total)",
                    paginate: {
                        first: "Primero",
                        last: "Último",
                        next: "Siguiente",
                        previous: "Anterior"
                    }
                },
                pageLength: 10,
                responsive: true,
                ordering: true,
                searching: true,
                dom: '<"d-flex justify-content-between align-items-center mb-2"Bf>rtip',
                buttons: [
                    { extend: 'copy', text: '📋 Copiar', className: 'btn btn-secondary' },
                    { extend: 'excel', text: '📊 Excel', className: 'btn btn-success' },
                    { extend: 'pdf', text: '📄 PDF', className: 'btn btn-danger' },
                    { extend: 'print', text: '🖨️ Imprimir', className: 'btn btn-info' }
                ],
                pagingType: "full_numbers",
                renderer: 'bootstrap',

                // 👇 Ordenar alfabéticamente (natural) por la primera columna (Nombre)
                columnDefs: [
                    { targets: 0, type: 'natural' },
                    { targets: 2, type: "num" },       // Cantidad
                    { targets: 3, type: "num-fmt" },   // Precio Compra
                    { targets: 4, type: "num-fmt" }    // Precio Venta
                ],
                order: [[0, 'asc']]
            });
        });
    </script>
@endpush