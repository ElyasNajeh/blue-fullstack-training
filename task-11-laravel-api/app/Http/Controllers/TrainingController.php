<?php

namespace App\Http\Controllers;

class TrainingController extends Controller
{
    public function profile()
    {
        return response()->json([
            'id' => 1,
            'name' => 'Elyas',
            'training_track' => 'Full-Stack Development',
            'current_task' => 11
        ], 200);
    }
    public function skills()
    {
        return response()->json([
            'HTML',
            'CSS',
            'JavaScript',
            'Vue.js',
            'PHP',
            'Laravel'
        ], 200);
    }
    public function tasks()
    {
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
    }
}
