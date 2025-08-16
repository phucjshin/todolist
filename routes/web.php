<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::get('/', [TaskController::class, 'index']);
Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
Route::patch('/tasks/{task}status', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');
Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
Route::put('/tasks/{task}/title', [TaskController::class, 'updateTitle'])->name('tasks.updateTitle');
// Route::patch('/tasks/{task}/restore', [TaskController::class, 'restore'])->name('tasks.restore');
Route::post('/tasks/{id}/pending', [TaskController::class, 'pending'])->name('tasks.pending');
