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

<div class="task bg-yellow-100 p-3 rounded shadow"
data-id="{{ $task->id }}">

<p class="font-semibold">{{ $task->titulo }}</p>

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

<div class="task bg-blue-100 p-3 rounded shadow"
data-id="{{ $task->id }}">

<p class="font-semibold">{{ $task->titulo }}</p>

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

<div class="task bg-green-100 p-3 rounded shadow"
data-id="{{ $task->id }}">

<p class="font-semibold">{{ $task->titulo }}</p>

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

</body>

</html>