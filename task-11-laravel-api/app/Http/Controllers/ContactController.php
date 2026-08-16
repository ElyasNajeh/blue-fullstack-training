<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'nullable',
            'message' => 'required|min:10',
        ]);

        return response()->json([
            'message' => 'Contact request submitted successfully',
            'data' => $validated
        ], 200);
    }
}
