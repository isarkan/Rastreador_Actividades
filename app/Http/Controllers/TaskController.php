<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\TaskHistory;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    $tasks = \App\Models\Task::all();
    return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    \App\Models\Task::create([
        'titulo' => $request->titulo,
        'descripcion' => $request->descripcion,
        'estado' => $request->estado,
        'fecha_limite' => $request->fecha_limite,
        'user_id' => null
    ]);

    return redirect()->route('tasks.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    $task = \App\Models\Task::with('historial.usuario')->findOrFail($id);

    return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
    $task = \App\Models\Task::findOrFail($id);
    return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    $task = Task::findOrFail($id);

    $estadoAnterior = $task->estado;

    $task->update($request->all());

    if ($estadoAnterior != $task->estado) {
        TaskHistory::create([
            'task_id' => $task->id,
            'user_id' => auth()->id(),
            'accion' => 'editó la tarea',
            'estado_anterior' => $estadoAnterior,
            'estado_nuevo' => $task->estado
        ]);
    }

    return redirect()->route('tasks.index');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    \App\Models\Task::destroy($id);
    return redirect()->route('tasks.index');
    }

    public function dashboard()
    {
    $pendientes = \App\Models\Task::where('estado', 'pendiente')
        ->whereNull('user_id')
        ->get();

    $proceso = \App\Models\Task::where('estado', 'proceso')
        ->whereNull('user_id')
        ->get();

    $completadas = \App\Models\Task::where('estado', 'completada')
        ->whereNull('user_id')
        ->get();

    return view('dashboard', compact('pendientes', 'proceso', 'completadas'));
    }

    public function updateStatus(Request $request)
    {
    $task = Task::find($request->id);

    $estadoAnterior = $task->estado;

    $task->estado = $request->estado;
    $task->save();

    TaskHistory::create([
        'task_id' => $task->id,
        'user_id' => auth()->id(),
        'accion' => 'cambió el estado',
        'estado_anterior' => $estadoAnterior,
        'estado_nuevo' => $request->estado
    ]);

    return response()->json(['success' => true]);
    }

    public function updateFromDashboard(Request $request)
    {
    $task = \App\Models\Task::find($request->id);

    $task->titulo = $request->titulo;
    $task->descripcion = $request->descripcion;
    $task->estado = $request->estado;

    $task->save();

    return response()->json(['success'=>true]);
    }

    public function misTareas()
    {
    $pendientes = \App\Models\Task::where('estado', 'pendiente')
        ->where('user_id', auth()->id())
        ->get();

    $proceso = \App\Models\Task::where('estado', 'proceso')
        ->where('user_id', auth()->id())
        ->get();

    $completadas = \App\Models\Task::where('estado', 'completada')
        ->where('user_id', auth()->id())
        ->get();

    return view('mis_tareas', compact('pendientes', 'proceso', 'completadas'));
    }

   public function tomarTarea($id)
    {
    $task = Task::findOrFail($id);

    $estadoAnterior = $task->estado;
    $usuarioAnterior = $task->user_id;

    $task->user_id = auth()->id();
    $task->save();

    TaskHistory::create([
        'task_id' => $task->id,
        'user_id' => auth()->id(),
        'accion' => 'tomó la tarea',
        'estado_anterior' => $estadoAnterior,
        'estado_nuevo' => $task->estado
    ]);
    return redirect('/mis-tareas');
    }

    public function liberarTarea($id)
    {
    $task = Task::findOrFail($id);

    $estadoAnterior = $task->estado;

    $task->user_id = null;
    $task->save();

    TaskHistory::create([
        'task_id' => $task->id,
        'user_id' => auth()->id(),
        'accion' => 'liberó la tarea',
        'estado_anterior' => $estadoAnterior,
        'estado_nuevo' => $task->estado
    ]);

    return redirect('/mis-tareas');
    }
    


}
