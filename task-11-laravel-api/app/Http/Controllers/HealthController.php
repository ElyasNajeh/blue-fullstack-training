<?php

namespace App\Http\Controllers;

class HealthController extends Controller
{
    public function health()
    {
        return response()->json([
            'status' => 'ok',
            'application' => 'Task 11 Laravel API',
            'message' => 'Application is running successfully'
        ], 200);
    }
}
