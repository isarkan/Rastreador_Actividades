<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::resource('tasks', TaskController::class);
Route::post('/tasks/update-status', [TaskController::class, 'updateStatus']);
Route::post('/tasks/update', [TaskController::class, 'updateFromDashboard']);
Route::get('/dashboard', [TaskController::class, 'dashboard']);
Route::get('/', function () {
    return view('welcome');

});
