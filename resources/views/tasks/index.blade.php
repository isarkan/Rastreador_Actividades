<!DOCTYPE html>
<html>
<head>
    <title>Gestor de Tareas</title>
</head>
<body>

<h1>Rastreador de Actividades</h1>

<h2>Crear nueva tarea</h2>

<form action="{{ route('tasks.store') }}" method="POST">
    @csrf

    <input type="text" name="titulo" placeholder="Título" required>

    <br><br>

    <textarea name="descripcion" placeholder="Descripción"></textarea>

    <br><br>

    <select name="estado">
        <option value="pendiente">Pendiente</option>
        <option value="proceso">En proceso</option>
        <option value="completada">Completada</option>
    </select>

    <br><br>

    <input type="date" name="fecha_limite">

    <br><br>

    <button type="submit">Guardar tarea</button>

</form>

<hr>

<h2>Lista de tareas</h2>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Título</th>
        <th>Estado</th>
        <th>Fecha límite</th>
        <th>Acciones</th>
    </tr>

    @foreach($tasks as $task)

    <tr>
        <td>{{ $task->id }}</td>
        <td>{{ $task->titulo }}</td>
        <td>{{ $task->estado }}</td>
        <td>{{ $task->fecha_limite }}</td>

        <td>

            <a href="{{ route('tasks.edit', $task->id) }}">
                Editar
            </a>
            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit">Eliminar</button>

            </form>

        </td>

    </tr>

    @endforeach

</table>

</body>
</html>