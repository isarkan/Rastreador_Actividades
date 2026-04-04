<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>

    <input 
        type="text" 
        id="buscador"
        placeholder="🔍 Buscar tareas..."
        class="w-full p-3 mb-6 border rounded shadow"
    >

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen p-10">

<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-3xl font-bold">
            📌 Mis Tareas
        </h1>
    </div>

    <div class="flex gap-2">
        <a href="/dashboard" class="bg-gray-500 text-white px-4 py-2 rounded shadow">
            Volver al dashboard
        </a>
        <form method="POST" action="/logout">
            @csrf
            <button class="bg-red-500 text-white px-4 py-2 rounded shadow">
                Cerrar sesión
            </button>
    </div>
</div>

<div class="grid grid-cols-3 gap-6">
    @php
        $columnas = [
            [
                'titulo' => 'Pendientes',
                'clase' => 'text-yellow-600',
                'tasks' => $pendientes,
                'id' => 'pendiente',
            ],
            [
                'titulo' => 'En proceso',
                'clase' => 'text-blue-600',
                'tasks' => $proceso,
                'id' => 'proceso',
            ],
            [
                'titulo' => 'Completadas',
                'clase' => 'text-green-600',
                'tasks' => $completadas,
                'id' => 'completada',
            ],
        ];
    @endphp

    @foreach($columnas as $columna)
        <div class="bg-white rounded-lg shadow p-4">
            <h2 class="text-xl font-bold {{ $columna['clase'] }} mb-4">
                {{ $columna['titulo'] }} ({{ count($columna['tasks']) }})
            </h2>

            <div id="{{ $columna['id'] }}" class="task-list space-y-3 min-h-[200px]">
                @foreach($columna['tasks'] as $task)
                    @php
                        $vencida = $task->fecha_limite && $task->fecha_limite < now() && $task->estado != 'completada';
                        $cardClass = $vencida ? 'bg-red-300 border-2 border-red-600' : 'bg-yellow-100';
                        $taskData = [
                            'id' => $task->id,
                            'titulo' => $task->titulo,
                            'descripcion' => $task->descripcion,
                            'estado' => $task->estado,
                        ];
                    @endphp

                    <div class="task p-3 rounded shadow {{ $cardClass }}"
                         data-id="{{ $task->id }}"
                         data-titulo="{{ strtolower($task->titulo) }}"
                         data-descripcion="{{ strtolower($task->descripcion) }}">
                        
                        @if($vencida)
                            <p class="text-xs text-red-700 font-bold">
                                ⚠ Tarea vencida
                            </p>
                        @endif

                        <p class="font-semibold">{{ $task->titulo }}</p>
                        <p class="text-xs text-gray-500">📅 {{ $task->fecha_limite }}</p>
                        <p class="text-sm text-gray-600">{{ $task->descripcion }}</p>

                        <div class="flex gap-2 mt-2">
                            @auth
                                <button onclick='editarTask(@json($taskData))'
                                        class="text-xs text-blue-600">
                                    Editar
                                </button>

                                <!-- <button onclick="editarTask({{ json_encode($taskData) }})"
                                        class="text-xs text-blue-600">
                                    Editar
                                </button> -->
                            @endauth

                            <form method="POST" action="/tasks/tomar/{{ $task->id }}">
                                @csrf
                                <button class="bg-green-500 text-white px-3 py-1 rounded text-xs">
                                    Tomar tarea
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</div>

<!-- Modal de edición -->
<div id="modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white p-6 rounded w-96">
        <h2 class="text-xl font-bold mb-4">Editar tarea</h2>

        <input id="editTitulo" class="border p-2 w-full mb-2" placeholder="Título">
        <textarea id="editDescripcion" class="border p-2 w-full mb-2" placeholder="Descripción"></textarea>
        <select id="editEstado" class="border p-2 w-full mb-4">
            <option value="pendiente">Pendiente</option>
            <option value="proceso">En proceso</option>
            <option value="completada">Completada</option>
        </select>

        <div class="flex justify-end gap-2">
            <button onclick="cerrarModal()" class="bg-gray-400 text-white px-3 py-1 rounded">
                Cancelar
            </button>
            <button onclick="guardarCambios()" class="bg-blue-600 text-white px-3 py-1 rounded">
                Guardar
            </button>
        </div>
    </div>
</div>


</body>
</html>