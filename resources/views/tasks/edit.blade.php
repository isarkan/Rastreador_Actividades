<!DOCTYPE html>
<html>
<head>
    <title>Editar tarea</title>
</head>
<body>

<h1>Editar tarea</h1>

<form action="{{ route('tasks.update', $task->id) }}" method="POST">

    @csrf
    @method('PUT')

    <input type="text" name="titulo" value="{{ $task->titulo }}" required>

    <br><br>

    <textarea name="descripcion">{{ $task->descripcion }}</textarea>

    <br><br>

    <select name="estado">

        <option value="pendiente" {{ $task->estado == 'pendiente' ? 'selected' : '' }}>Pendiente</option>

        <option value="proceso" {{ $task->estado == 'proceso' ? 'selected' : '' }}>En proceso</option>

        <option value="completada" {{ $task->estado == 'completada' ? 'selected' : '' }}>Completada</option>

    </select>

    <br><br>

    <input type="date" name="fecha_limite" value="{{ $task->fecha_limite }}">

    <br><br>

    <button type="submit">Actualizar tarea</button>

</form>

<br>

<a href="/tasks">Volver</a>

</body>
</html>