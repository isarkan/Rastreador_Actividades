<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);


// 🌍 Dashboard público
Route::get('/dashboard', [TaskController::class, 'dashboard']);


// 🔐 Rutas protegidas
Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/mis-tareas', [TaskController::class, 'misTareas']);

    Route::post('/tasks/tomar/{id}', [TaskController::class, 'tomarTarea']);

    Route::post('/tasks/liberar/{id}', [TaskController::class, 'liberarTarea']);
    
    Route::post('/tasks/update-status', [TaskController::class, 'updateStatus']);

    Route::post('/tasks/update', [TaskController::class, 'updateFromDashboard']);

    Route::resource('tasks', TaskController::class);
});