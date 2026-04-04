<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Gráficas</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<a href="/dashboard" class="bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-600">
                Volver al dashboard
            </a>

            <style>
                body > a[href="/dashboard"] {
                    position: absolute;
                    top: 1rem;
                    right: 1rem;
                    margin: 0;
                }

                .kpi-spacing {
                    margin-top: 5rem;
                }
            </style>
            <div class="kpi-spacing"></div>

<body class="bg-gray-100 min-h-screen">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white shadow rounded p-4">
            <p class="text-sm text-gray-500">Total tareas</p>
            <p class="text-2xl font-bold">{{ $totalTareas }}</p>
        </div>

        <div class="bg-white shadow rounded p-4">
            <p class="text-sm text-gray-500">Pendientes</p>
            <p class="text-2xl font-bold">{{ $pendientes }}</p>
        </div>

        <div class="bg-white shadow rounded p-4">
            <p class="text-sm text-gray-500">Completadas</p>
            <p class="text-2xl font-bold">{{ $completadas }}</p>
        </div>

        <div class="bg-white shadow rounded p-4">
            <p class="text-sm text-gray-500">Usuario top</p>
            <p class="text-lg font-bold">
                {{ $usuarioTop->usuario->name ?? 'Sin datos' }}
            </p>
        </div>
    </div>

    <div class="mt-6 bg-white shadow rounded p-4">
        <h2 class="font-semibold mb-4">Tareas completadas por día</h2>
        <canvas id="lineaChart"></canvas>
    </div>

    <div class="p-6">
        <h1 class="text-2xl font-bold mb-6">Gráficas del sistema</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white shadow rounded p-4">
                <h2 class="font-semibold mb-4">Estado de tareas</h2>
                <canvas id="estadoChart"></canvas>
            </div>

            <div class="bg-white shadow rounded p-4">
                <h2 class="font-semibold mb-4">Top usuarios</h2>
                <canvas id="usuariosChart"></canvas>
            </div>
        </div>
    </div>

    <script>
        window.reporteEstados = [
            {{ $pendientes }},
            {{ $proceso }},
            {{ $completadas }}
        ];

        window.topUsuariosNombres = @json($nombresUsuarios);
        window.topUsuariosValores = @json($totalesUsuarios);
        window.fechas = @json($fechas);
        window.totalesPorDia = @json($totalesPorDia);
    </script>

</body>
</html>