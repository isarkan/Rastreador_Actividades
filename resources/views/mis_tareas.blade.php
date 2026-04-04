<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Mis Tareas</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen p-10">

    {{-- Buscador --}}
    <div class="mb-6">
        <input 
            type="text" 
            id="buscador"
            placeholder="🔍 Buscar tareas..."
            class="w-full p-3 border rounded shadow"
        >
    </div>

    {{-- Header --}}
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">📌 Mis tareas</h1>
        <p class="text-gray-600">
            Bienvenido, {{ auth()->user()->name }}
        </p>
        <div class="flex gap-2">
            <a href="/dashboard" class="bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-600">
                Volver al dashboard
            </a>
            <form method="POST" action="/logout">
                @csrf
                <button class="bg-red-500 text-white px-4 py-2 rounded shadow hover:bg-red-600">
                    Cerrar sesión
                </button>
            </form>
         </div>
    </div>

    @php
        $columnas = [
            'pendiente' => ['titulo' => 'Pendientes', 'color' => 'yellow', 'tareas' => $pendientes],
            'proceso' => ['titulo' => 'En proceso', 'color' => 'blue', 'tareas' => $proceso],
            'completada' => ['titulo' => 'Completadas', 'color' => 'green', 'tareas' => $completadas],
        ];
    @endphp

    {{-- Tablero --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($columnas as $estado => $columna)
            <div class="bg-white rounded-lg shadow p-4">
                <h2 class="text-xl font-bold text-{{ $columna['color'] }}-600 mb-4">
                    {{ $columna['titulo'] }} ({{ count($columna['tareas']) }})
                </h2>

                <div id="{{ $estado }}" class="task-list space-y-3 min-h-[200px]">
                    @foreach($columna['tareas'] as $task)
                        @php
                            $vencida = $task->fecha_limite 
                                && $task->fecha_limite < now() 
                                && $task->estado != 'completada';
                        @endphp

                        <div 
                            class="task p-3 rounded shadow {{ $vencida ? 'bg-red-300 border-2 border-red-600' : 'bg-yellow-100' }}"
                            data-id="{{ $task->id }}"
                            data-titulo="{{ strtolower($task->titulo) }}"
                            data-descripcion="{{ strtolower($task->descripcion) }}"
                        >
                            @if($vencida)
                                <p class="text-xs text-red-700 font-bold">
                                    ⚠ Tarea vencida
                                </p>
                            @endif

                            <p class="font-semibold">{{ $task->titulo }}</p>

                            <p class="text-xs text-gray-500">
                                📅 {{ $task->fecha_limite }}
                            </p>

                            <p class="text-sm text-gray-600">
                                {{ $task->descripcion }}
                            </p>
                            <div class="flex gap-2">
                            <button class="bg-blue-500 text-white px-3 py-1 rounded mt-2 text-sm hover:bg-orange-600" 
                                onclick="editarTask(
                                    {{ $task->id }},
                                    '{{ addslashes($task->titulo) }}',
                                    '{{ addslashes($task->descripcion) }}',
                                    '{{ $task->estado }}'
                                )"
                                class="text-xs text-blue-600 mt-2"
                            >
                                Editar
                            </button>

                            <form method="POST" action="/tasks/liberar/{{ $task->id }}">
                                @csrf
                                <button class="bg-orange-500 text-white px-3 py-1 rounded mt-2 text-sm hover:bg-orange-600">
                                    🔄 Liberar tarea
                                </button>
                            </form>
                            </div>
                        </div>

                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    {{-- Modal --}}
    <div id="modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white p-6 rounded w-96 shadow-lg">
            <h2 class="text-xl font-bold mb-4">Editar tarea</h2>

            <input id="editTitulo" class="border p-2 w-full mb-2" placeholder="Título">

            <textarea 
                id="editDescripcion" 
                class="border p-2 w-full mb-2" 
                placeholder="Descripción"
            ></textarea>

            <select id="editEstado" class="border p-2 w-full mb-4">
                <option value="pendiente">Pendiente</option>
                <option value="proceso">En proceso</option>
                <option value="completada">Completada</option>
            </select>

            <div class="flex justify-end gap-2">
                <button onclick="cerrarModal()" class="bg-gray-400 text-white px-3 py-1 rounded hover:bg-gray-500">
                    Cancelar
                </button>

                <button onclick="guardarCambios()" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                    Guardar
                </button>
            </div>
        </div>
    </div>

</body>
</html>