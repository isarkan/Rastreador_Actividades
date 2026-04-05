<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de la tarea</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-100 min-h-screen p-8">

    <div class="max-w-4xl mx-auto">

        <!-- Botón volver -->
        <div class="mb-6">
            <a 
                href="/dashboard"
                class="inline-block bg-gray-700 text-white px-5 py-3 rounded-lg hover:bg-gray-800 transition"
            >
                ⬅️ Volver al Dashboard
            </a>
        </div>

        <!-- Información de la tarea -->
        <div class="bg-white shadow-lg rounded-xl p-6 mb-8">
            <h2 class="text-3xl font-bold text-blue-700 mb-6">
                📋 Detalle de la tarea
            </h2>

            <div class="space-y-3 text-lg">
                <p>
                    <strong class="text-gray-700">Título:</strong> 
                    {{ $task->titulo }}
                </p>

                <p>
                    <strong class="text-gray-700">Estado:</strong> 
                    <span class="
                        px-3 py-1 rounded-full text-white text-sm
                        @if($task->estado == 'pendiente') bg-yellow-500
                        @elseif($task->estado == 'proceso') bg-blue-500
                        @else bg-green-500
                        @endif
                    ">
                        {{ ucfirst($task->estado) }}
                    </span>
                </p>
            </div>
        </div>

        <!-- Historial -->
        <div class="bg-white shadow-lg rounded-xl p-6">
            <h3 class="text-2xl font-semibold text-gray-700 mb-6">
                🕒 Historial de cambios
            </h3>

            @forelse($task->historial->sortByDesc('created_at') as $item)
                <div class="mb-4 border-l-4 border-blue-500 bg-gray-50 p-4 rounded-lg shadow-sm">
                    <p class="font-semibold text-gray-800">
                        👤 {{ $item->usuario->name ?? 'Sistema' }}
                    </p>

                    <p class="text-gray-700">
                        {{ $item->accion }}
                    </p>

                    <p class="text-sm text-gray-500 mt-1">
                        🔄 {{ $item->estado_anterior }} → {{ $item->estado_nuevo }}
                    </p>

                    <p class="text-sm text-gray-400 mt-1">
                        📅 {{ $item->created_at->format('d/m/Y H:i') }}
                    </p>
                </div>
            @empty
                <div class="text-center text-gray-500 py-8">
                    📭 No hay historial disponible
                </div>
            @endforelse
        </div>

    </div>

</body>
</html>