<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HealthController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PostController;

Route::get('/health', [HealthController::class, 'health']);

Route::get('/profile', [TrainingController::class, 'profile']);
Route::get('/skills', [TrainingController::class, 'skills']);
Route::get('/training/tasks', [TrainingController::class, 'tasks']);
Route::get('/training/tasks/{id}', [TrainingController::class, 'taskById']);

Route::post('/contact', [ContactController::class, 'store']);

Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/{id}', [PostController::class, 'show']);
Route::post('/posts', [PostController::class, 'store']);
Route::put('/posts/{id}', [PostController::class, 'update']);
Route::delete('/posts/{id}', [PostController::class, 'destroy']);
