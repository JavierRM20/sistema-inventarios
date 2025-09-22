<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Inventarios</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <!-- DataTables Buttons CSS -->
    <link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css" rel="stylesheet">

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

        .dataTables_wrapper .dataTables_paginate .pagination {
            justify-content: flex-end;
            /* o center para centrar */
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
</head>

<body>

    {{-- Sidebar --}}
    <div class="sidebar">
        {{-- Sección de usuario --}}
        <div class="p-3 border-bottom text-center">
            <!-- Avatar -->
            <div class="rounded-circle bg-primary text-white fw-bold d-flex align-items-center justify-content-center mx-auto mb-2"
                style="width: 50px; height: 50px; font-size: 20px;">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <!-- Nombre + Rol -->
            <h6 class="mb-0">{{ Auth::user()->name }}</h6>
        </div>

        {{-- Menú principal con acordeón --}}
        <div class="accordion accordion-flush" id="menuAccordion">
            <!-- Dashboard -->
            <div class="accordion-item bg-dark text-light">
                <h2 class="accordion-header">
                    <a href="{{ route('dashboard') }}"
                        class="accordion-button collapsed bg-dark text-light border-0 {{ request()->is('dashboard') ? 'active' : '' }}">
                        🏠 Inicio
                    </a>
                </h2>
            </div>

            <!-- Productos -->
            <div class="accordion-item bg-dark text-light">
                <h2 class="accordion-header" id="headingProductos">
                    <button
                        class="accordion-button bg-dark text-light {{ request()->is('productos*') ? '' : 'collapsed' }}"
                        type="button" data-bs-toggle="collapse" data-bs-target="#collapseProductos"
                        aria-expanded="{{ request()->is('productos*') ? 'true' : 'false' }}"
                        aria-controls="collapseProductos">
                        📋 Productos
                    </button>
                </h2>
                <div id="collapseProductos"
                    class="accordion-collapse collapse {{ request()->is('productos*') ? 'show' : '' }}"
                    data-bs-parent="#menuAccordion">
                    <div class="accordion-body bg-secondary">
                        <a href="{{ route('productos.index') }}"
                            class="d-block text-light {{ request()->is('productos') ? 'fw-bold text-white' : '' }}">📦
                            Listar</a>
                        <a href="{{ route('productos.create') }}"
                            class="d-block text-light {{ request()->is('productos/create') ? 'fw-bold text-white' : '' }}">➕
                            Crear</a>
                    </div>
                </div>
            </div>

            <!-- Usuarios (solo visible para admin) -->
            @if(Auth::check() && Auth::user()->role === 'admin')
                <div class="accordion-item bg-dark text-light">
                    <h2 class="accordion-header" id="headingUsuarios">
                        <button
                            class="accordion-button bg-dark text-light {{ request()->is('usuarios*') ? '' : 'collapsed' }}"
                            type="button" data-bs-toggle="collapse" data-bs-target="#collapseUsuarios"
                            aria-expanded="{{ request()->is('usuarios*') ? 'true' : 'false' }}"
                            aria-controls="collapseUsuarios">
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

            <!-- Reportes -->
            <div class="accordion-item bg-dark text-light">
                <h2 class="accordion-header">
                    <a href="#"
                        class="accordion-button collapsed bg-dark text-light border-0 {{ request()->is('reportes*') ? 'active' : '' }}">
                        📊 Reportes
                    </a>
                </h2>
            </div>

            <!-- Configuración -->
            <div class="accordion-item bg-dark text-light">
                <h2 class="accordion-header">
                    <a href="#"
                        class="accordion-button collapsed bg-dark text-light border-0 {{ request()->is('configuracion*') ? 'active' : '' }}">
                        ⚙️ Configuración
                    </a>
                </h2>
            </div>

            <!-- Cerrar sesión -->
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

    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- DataTables Core -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <!-- DataTables con integración Bootstrap 5 -->
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <!-- DataTables Buttons -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>

    <!-- JSZip y pdfmake para exportaciones -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    @stack('scripts')

    <script>
        function togglePassword(id) {
            const input = document.getElementById(id);
            input.type = input.type === "password" ? "text" : "password";
        }
    </script>
</body>

</html>