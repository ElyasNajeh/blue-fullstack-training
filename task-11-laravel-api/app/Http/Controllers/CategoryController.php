<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return CategoryResource::collection($categories);
    }
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:categories,slug',
            ]
        );
        $category  = Category::create($validated);
        return (new CategoryResource($category))
            ->response()
            ->setStatusCode(201);
    }
}
