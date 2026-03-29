<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="bg-gray-100 min-h-screen p-10">

<h1 class="text-3xl font-bold text-center mb-8">
📊 Rastreador de Actividades
</h1>

<div class="grid grid-cols-3 gap-6">

<!-- Pendientes -->

<div class="bg-white rounded-lg shadow p-4">

<h2 class="text-xl font-bold text-yellow-600 mb-4">
Pendientes ({{ count($pendientes) }})
</h2>

<div id="pendiente" class="task-list space-y-3 min-h-[200px]">

@foreach($pendientes as $task)

@php
    $vencida = $task->fecha_limite && $task->fecha_limite < now() && $task->estado != 'completada';
@endphp

<div class="task p-3 rounded shadow
    {{ $vencida ? 'bg-red-300 border-2 border-red-600' : 'bg-yellow-100' }}"
    data-id="{{ $task->id }}">

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

<button onclick="editarTask({{ $task->id }}, '{{ $task->titulo }}', '{{ $task->descripcion }}', '{{ $task->estado }}')"
class="text-xs text-blue-600 mt-2">
Editar
</button>

</div>

@endforeach

</div>

</div>

<!-- En proceso -->

<div class="bg-white rounded-lg shadow p-4">

<h2 class="text-xl font-bold text-blue-600 mb-4">
En proceso ({{ count($proceso) }})
</h2>

<div id="proceso" class="task-list space-y-3 min-h-[200px]">

@foreach($proceso as $task)

@php
    $vencida = $task->fecha_limite && $task->fecha_limite < now() && $task->estado != 'completada';
@endphp

<div class="task p-3 rounded shadow
    {{ $vencida ? 'bg-red-300 border-2 border-red-600' : 'bg-yellow-100' }}"
    data-id="{{ $task->id }}">

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

<button onclick="editarTask({{ $task->id }}, '{{ $task->titulo }}', '{{ $task->descripcion }}', '{{ $task->estado }}')"
class="text-xs text-blue-600 mt-2">
Editar
</button>

</div>

@endforeach

</div>

</div>

<!-- Completadas -->

<div class="bg-white rounded-lg shadow p-4">

<h2 class="text-xl font-bold text-green-600 mb-4">
Completadas ({{ count($completadas) }})
</h2>

<div id="completada" class="task-list space-y-3 min-h-[200px]">

@foreach($completadas as $task)

@php
    $vencida = $task->fecha_limite && $task->fecha_limite < now() && $task->estado != 'completada';
@endphp

<div class="task p-3 rounded shadow
    {{ $vencida ? 'bg-red-300 border-2 border-red-600' : 'bg-yellow-100' }}"
    data-id="{{ $task->id }}">

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

<button onclick="editarTask({{ $task->id }}, '{{ $task->titulo }}', '{{ $task->descripcion }}', '{{ $task->estado }}')"
class="text-xs text-blue-600 mt-2">
Editar
</button>

</div>

@endforeach

</div>

</div>

</div>

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