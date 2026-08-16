<?php

use Illuminate\Support\Facades\Route;

Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'application' => 'Task 11 Laravel API',
        'message' => 'Application is running successfully'
    ], 200);
});

Route::get('/profile', function () {
    return response()->json([
        'id' => 1,
        'name' => 'Elyas',
        'training_track' => 'Full-Stack Development',
        'current_task' => 11
    ], 200);
});

Route::get('/skills', function () {
    return response()->json([
        'HTML',
        'CSS',
        'JavaScript',
        'Vue.js',
        'PHP',
        'Laravel'
    ], 200);
});


Route::get('/training/tasks', function () {
    return response()->json([
        [
            'id' => 1,
            'title' => 'HTML & CSS Fundamentals',
            'status' => 'completed',
            'estimated_hours' => 8
        ],
        [
            'id' => 2,
            'title' => 'JavaScript Fundamentals',
            'status' => 'completed',
            'estimated_hours' => 8
        ],
        [
            'id' => 3,
            'title' => 'Vue.js Fundamentals',
            'status' => 'completed',
            'estimated_hours' => 8
        ],
        [
            'id' => 4,
            'title' => 'Vue.js API Integration',
            'status' => 'completed',
            'estimated_hours' => 8
        ],
        [
            'id' => 5,
            'title' => 'Laravel Backend Foundations',
            'status' => 'in_progress',
            'estimated_hours' => 8
        ]
    ], 200);
});
