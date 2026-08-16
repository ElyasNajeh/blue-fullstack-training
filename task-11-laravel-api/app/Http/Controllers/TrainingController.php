<?php

namespace App\Http\Controllers;

class TrainingController extends Controller
{
    private array $tasks = [
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
    ];
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
        return response()->json($this->tasks, 200);
    }
    public function taskById($id)
    {
        foreach ($this->tasks as $task) {
            if ($task['id'] == $id) {
                return response()->json($task, 200);
            }
        }

        return response()->json([
            'message' => 'Task not found'
        ], 404);
    }
}
