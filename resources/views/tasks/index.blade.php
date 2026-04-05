<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Tareas</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-100 min-h-screen p-8">

    <div class="max-w-6xl mx-auto">
        
        <!-- Título -->
        <h1 class="text-4xl font-bold text-center text-blue-700 mb-8">
            📋 Rastreador de Actividades
        </h1>

        <!-- Formulario -->
        <div class="bg-white shadow-lg rounded-xl p-6 mb-10">
            <h2 class="text-2xl font-semibold mb-4 text-gray-700">
                ➕ Crear nueva tarea
            </h2>

            <form action="{{ route('tasks.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block font-medium text-gray-600">Título</label>
                    <input 
                        type="text" 
                        name="titulo" 
                        placeholder="Ingrese el título"
                        required
                        class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-blue-400 outline-none"
                    >
                </div>

                <div>
                    <label class="block font-medium text-gray-600">Descripción</label>
                    <textarea 
                        name="descripcion" 
                        placeholder="Ingrese una descripción"
                        class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-blue-400 outline-none"
                    ></textarea>
                </div>

                <div>
                    <label class="block font-medium text-gray-600">Estado</label>
                    <select 
                        name="estado"
                        class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-blue-400 outline-none"
                    >
                        <option value="pendiente">Pendiente</option>
                        <option value="proceso">En proceso</option>
                        <option value="completada">Completada</option>
                    </select>
                </div>

                <div>
                    <label class="block font-medium text-gray-600">Fecha límite</label>
                    <input 
                        type="date" 
                        name="fecha_limite"
                        class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-blue-400 outline-none"
                    >
                </div>

                <button 
                    type="submit"
                    class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition"
                >
                    💾 Guardar tarea
                </button>

                <a href="/dashboard" class="bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-600">
                Volver al dashboard
            </a>
            
            </form>
        </div>

        <!-- Tabla -->
        <div class="bg-white shadow-lg rounded-xl p-6">
            <h2 class="text-2xl font-semibold mb-4 text-gray-700">
                📑 Lista de tareas
            </h2>

            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-blue-600 text-white">
                            <th class="p-3 text-left">ID</th>
                            <th class="p-3 text-left">Título</th>
                            <th class="p-3 text-left">Estado</th>
                            <th class="p-3 text-left">Fecha límite</th>
                            <th class="p-3 text-left">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tasks as $task)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3">{{ $task->id }}</td>
                            <td class="p-3 font-medium">{{ $task->titulo }}</td>
                            <td class="p-3">
                                <span class="
                                    px-3 py-1 rounded-full text-sm text-white
                                    @if($task->estado == 'pendiente') bg-yellow-500
                                    @elseif($task->estado == 'proceso') bg-blue-500
                                    @else bg-green-500
                                    @endif
                                ">
                                    {{ ucfirst($task->estado) }}
                                </span>
                            </td>
                            <td class="p-3">{{ $task->fecha_limite }}</td>
                            <td class="p-3 flex gap-2">
                                <a 
                                    href="{{ route('tasks.edit', $task->id) }}"
                                    class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600"
                                >
                                    ✏️ Editar
                                </a>

                                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button 
                                        type="submit"
                                        class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700"
                                    >
                                        🗑️ Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</body>
</html>