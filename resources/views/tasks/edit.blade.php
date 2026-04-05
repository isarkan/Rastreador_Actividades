<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar tarea</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-100 min-h-screen p-8">

    <div class="max-w-3xl mx-auto">
        
        <!-- Título -->
        <h1 class="text-4xl font-bold text-center text-yellow-600 mb-8">
            ✏️ Editar tarea
        </h1>

        <!-- Formulario -->
        <div class="bg-white shadow-lg rounded-xl p-8">
            <form action="{{ route('tasks.update', $task->id) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <!-- Título -->
                <div>
                    <label class="block font-medium text-gray-700 mb-2">
                        Título
                    </label>
                    <input 
                        type="text" 
                        name="titulo" 
                        value="{{ $task->titulo }}" 
                        required
                        class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-yellow-400 outline-none"
                    >
                </div>

                <!-- Descripción -->
                <div>
                    <label class="block font-medium text-gray-700 mb-2">
                        Descripción
                    </label>
                    <textarea 
                        name="descripcion"
                        rows="4"
                        class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-yellow-400 outline-none"
                    >{{ $task->descripcion }}</textarea>
                </div>

                <!-- Estado -->
                <div>
                    <label class="block font-medium text-gray-700 mb-2">
                        Estado
                    </label>
                    <select 
                        name="estado"
                        class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-yellow-400 outline-none"
                    >
                        <option value="pendiente" {{ $task->estado == 'pendiente' ? 'selected' : '' }}>
                            Pendiente
                        </option>

                        <option value="proceso" {{ $task->estado == 'proceso' ? 'selected' : '' }}>
                            En proceso
                        </option>

                        <option value="completada" {{ $task->estado == 'completada' ? 'selected' : '' }}>
                            Completada
                        </option>
                    </select>
                </div>

                <!-- Fecha -->
                <div>
                    <label class="block font-medium text-gray-700 mb-2">
                        Fecha límite
                    </label>
                    <input 
                        type="date" 
                        name="fecha_limite" 
                        value="{{ $task->fecha_limite }}"
                        class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-yellow-400 outline-none"
                    >
                </div>

                <!-- Botones -->
                <div class="flex gap-3">
                    <button 
                        type="submit"
                        class="bg-yellow-500 text-white px-6 py-3 rounded-lg hover:bg-yellow-600 transition"
                    >
                        💾 Actualizar tarea
                    </button>

                    <a 
                        href="/tasks"
                        class="bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600 transition"
                    >
                        ⬅️ Volver
                    </a>
                </div>
            </form>
        </div>

    </div>

</body>
</html>