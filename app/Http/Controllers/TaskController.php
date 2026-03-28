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
    \App\Models\Task::create($request->all());
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
        $pendientes = \App\Models\Task::where('estado','pendiente')->get();
        $proceso = \App\Models\Task::where('estado','proceso')->get();
        $completadas = \App\Models\Task::where('estado','completada')->get();

        return view('dashboard', compact('pendientes','proceso','completadas'));
    }

    public function updateStatus(Request $request)
    {
    $task = \App\Models\Task::find($request->id);

    $task->estado = $request->estado;

    $task->save();

    return response()->json(['success' => true]);
    }

}
