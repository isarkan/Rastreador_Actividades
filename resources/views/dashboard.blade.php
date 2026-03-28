<!DOCTYPE html>
<html>
<head>
    <title>Dashboard de tareas</title>
</head>
<body>

<h1>Dashboard de Actividades</h1>

<a href="/tasks">Administrar tareas</a>

<hr>

<div style="display:flex; gap:50px">

<div>
<h2>Pendientes</h2>

@foreach($pendientes as $task)

<p>{{ $task->titulo }}</p>

@endforeach

</div>

<div>
<h2>En proceso</h2>

@foreach($proceso as $task)

<p>{{ $task->titulo }}</p>

@endforeach

</div>

<div>
<h2>Completadas</h2>

@foreach($completadas as $task)

<p>{{ $task->titulo }}</p>

@endforeach

</div>

</div>

</body>
</html>