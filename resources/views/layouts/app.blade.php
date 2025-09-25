<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Inventarios</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
        }

        .sidebar {
            width: 250px;
            background: #343a40;
            color: #fff;
            flex-shrink: 0;
        }

        .sidebar a {
            color: #adb5bd;
            text-decoration: none;
            display: block;
            padding: 12px 20px;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: #495057;
            color: #fff;
        }

        .content {
            flex-grow: 1;
            padding: 20px;
            background: #f8f9fa;
        }

        /* DataTables ajustes */
        .dataTables_wrapper .dataTables_paginate .pagination {
            justify-content: flex-end;
            margin-top: 10px;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0.5rem 0.75rem;
            margin: 0 2px;
            border-radius: 0.375rem;
            border: 1px solid #dee2e6;
            background: #fff;
            color: #0d6efd !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #0d6efd !important;
            color: #fff !important;
            border-color: #0d6efd !important;
        }
    </style>
    @yield('styles')
</head>

<body>
    {{-- Sidebar --}}
    <div class="sidebar">
        {{-- Usuario --}}
        <div class="p-3 border-bottom text-center">
            <div class="rounded-circle bg-primary text-white fw-bold d-flex align-items-center justify-content-center mx-auto mb-2"
                 style="width: 50px; height: 50px; font-size: 20px;">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <h6 class="mb-0">{{ Auth::user()->name }}</h6>
        </div>

        {{-- Menú --}}
        <div class="accordion accordion-flush" id="menuAccordion">
            <div class="accordion-item bg-dark text-light">
                <h2 class="accordion-header">
                    <a href="{{ route('dashboard') }}"
                       class="accordion-button collapsed bg-dark text-light border-0 {{ request()->is('dashboard') ? 'active' : '' }}">
                        🏠 Inicio
                    </a>
                </h2>
            </div>

            <div class="accordion-item bg-dark text-light">
                <h2 class="accordion-header" id="headingProductos">
                    <button class="accordion-button bg-dark text-light {{ request()->is('productos*') ? '' : 'collapsed' }}"
                            type="button" data-bs-toggle="collapse" data-bs-target="#collapseProductos"
                            aria-expanded="{{ request()->is('productos*') ? 'true' : 'false' }}">
                        📋 Productos
                    </button>
                </h2>
                <div id="collapseProductos"
                     class="accordion-collapse collapse {{ request()->is('productos*') ? 'show' : '' }}"
                     data-bs-parent="#menuAccordion">
                    <div class="accordion-body bg-secondary">
                        <a href="{{ route('productos.index') }}" class="d-block text-light">📦 Listar</a>
                        <a href="{{ route('productos.create') }}" class="d-block text-light">➕ Crear</a>
                    </div>
                </div>
            </div>

            @if(Auth::check() && Auth::user()->role === 'admin')
                <div class="accordion-item bg-dark text-light">
                    <h2 class="accordion-header" id="headingUsuarios">
                        <button class="accordion-button bg-dark text-light {{ request()->is('usuarios*') ? '' : 'collapsed' }}"
                                type="button" data-bs-toggle="collapse" data-bs-target="#collapseUsuarios"
                                aria-expanded="{{ request()->is('usuarios*') ? 'true' : 'false' }}">
                            👥 Usuarios
                        </button>
                    </h2>
                    <div id="collapseUsuarios"
                         class="accordion-collapse collapse {{ request()->is('usuarios*') ? 'show' : '' }}"
                         data-bs-parent="#menuAccordion">
                        <div class="accordion-body bg-secondary">
                            <a href="{{ route('usuarios.index') }}" class="d-block text-light">📋 Listar</a>
                            <a href="{{ route('usuarios.create') }}" class="d-block text-light">➕ Crear</a>
                        </div>
                    </div>
                </div>
            @endif

            <div class="accordion-item bg-dark text-light">
                <h2 class="accordion-header">
                    <a href="#" class="accordion-button collapsed bg-dark text-light border-0">
                        📊 Reportes
                    </a>
                </h2>
            </div>

            <div class="accordion-item bg-dark text-light">
                <h2 class="accordion-header">
                    <a href="#" class="accordion-button collapsed bg-dark text-light border-0">
                        ⚙️ Configuración
                    </a>
                </h2>
            </div>

            <div class="accordion-item bg-dark text-light">
                <h2 class="accordion-header">
                    <a href="{{ route('logout') }}" class="accordion-button collapsed bg-dark text-light border-0"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        🚪 Cerrar sesión
                    </a>
                </h2>
            </div>
        </div>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>

    {{-- Contenido principal --}}
    <div class="content">
        @yield('content')
    </div>

    <!-- jQuery primero -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables Core -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <!-- Librerías de exportación (desde DataTables CDN, correctas y en orden) -->
    <script src="https://cdn.datatables.net/plug-ins/1.13.7/jszip/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/plug-ins/1.13.7/pdfmake/pdfmake.min.js"></script>
    <script src="https://cdn.datatables.net/plug-ins/1.13.7/pdfmake/vfs_fonts.js"></script>

    <!-- DataTables Buttons -->
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>

    @stack('scripts')
</body>
</html>
