<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Test DataTables Export</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Prueba de Exportación DataTables</h1>

    <!-- Botones de exportación -->
    <div class="mb-3" id="exportButtons"></div>

    <!-- Tabla de prueba -->
    <table id="movimientosTable" class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Producto</th>
            <th>Tipo</th>
            <th>Cantidad</th>
        </tr>
        </thead>
        <tbody>
        <tr><td>1</td><td>Producto A</td><td>Entrada</td><td>10</td></tr>
        <tr><td>2</td><td>Producto B</td><td>Salida</td><td>5</td></tr>
        </tbody>
    </table>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- DataTables + Buttons -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<script>
    $(document).ready(function () {
        var table = $('#movimientosTable').DataTable({
            dom: 'Bfrtip', // muestra botones arriba de la tabla
            buttons: [
                { extend: 'copy', text: '<i class="bi bi-clipboard"></i> Copiar', className: 'btn btn-dark' },
                { extend: 'excelHtml5', text: '<i class="bi bi-file-earmark-excel"></i> Excel', className: 'btn btn-success' },
                { extend: 'pdfHtml5', text: '<i class="bi bi-file-earmark-pdf"></i> PDF', className: 'btn btn-danger' },
                { extend: 'print', text: '<i class="bi bi-printer"></i> Imprimir', className: 'btn btn-primary' }
            ]
        });

        // Mueve los botones al div #exportButtons
        table.buttons().container().appendTo('#exportButtons');
    });
</script>
</body>
</html>
