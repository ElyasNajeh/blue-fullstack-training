<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HealthController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ContentBlockController;


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

// Public Pages
Route::get('/pages', [PageController::class, 'index']);
Route::get('/pages/{slug}', [PageController::class, 'show']);

// Pages Management
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/manage/pages', [PageController::class, 'manageIndex']);

    Route::post('/pages', [PageController::class, 'store']);
    Route::put('/pages/{id}', [PageController::class, 'update']);
    Route::delete('/pages/{id}', [PageController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->group(function () {

    // Pages
    Route::get('/manage/pages', [PageController::class, 'manageIndex']);
    Route::post('/pages', [PageController::class, 'store']);
    Route::put('/pages/{id}', [PageController::class, 'update']);
    Route::delete('/pages/{id}', [PageController::class, 'destroy']);

    // Content Blocks
    Route::post('/pages/{pageId}/blocks', [ContentBlockController::class, 'store']);
    Route::put('/blocks/{id}', [ContentBlockController::class, 'update']);
    Route::delete('/blocks/{id}', [ContentBlockController::class, 'destroy']);
    Route::put('/pages/{pageId}/blocks/reorder', [ContentBlockController::class, 'reorder']);
});
