<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HealthController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthController;

Route::get('/health', [HealthController::class, 'health']);

Route::get('/profile', [TrainingController::class, 'profile']);
Route::get('/skills', [TrainingController::class, 'skills']);
Route::get('/training/tasks', [TrainingController::class, 'tasks']);
Route::get('/training/tasks/{id}', [TrainingController::class, 'taskById']);

Route::post('/contact', [ContactController::class, 'store']);

Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/{id}', [PostController::class, 'show']);
Route::post('/posts', [PostController::class, 'store'])
    ->middleware('auth:sanctum');

Route::put('/posts/{id}', [PostController::class, 'update'])
    ->middleware('auth:sanctum');

Route::delete('/posts/{id}', [PostController::class, 'destroy'])
    ->middleware('auth:sanctum');

Route::get('/categories', [CategoryController::class, 'index']);
Route::post('/categories', [CategoryController::class, 'store']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/me', [AuthController::class, 'me'])
    ->middleware('auth:sanctum');
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth:sanctum');
