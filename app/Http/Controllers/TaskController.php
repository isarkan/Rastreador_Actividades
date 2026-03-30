<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        //
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
    $task = \App\Models\Task::findOrFail($id);

    $task->update($request->all());

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
    $task = \App\Models\Task::find($request->id);

    $task->estado = $request->estado;

    $task->save();

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
    $task = \App\Models\Task::findOrFail($id);

    $task->user_id = auth()->id();
    $task->save();

    return redirect('/mis-tareas');
    }

}
