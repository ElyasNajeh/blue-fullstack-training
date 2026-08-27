<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::where('status', 'published')->get();

        return response()->json([
            'data' => $pages
        ], 200);
    }

    public function show($slug)
    {
        $page = Page::with('contentBlocks')
            ->where('slug', $slug)
            ->where('status', 'published')
            ->first();

        if (!$page) {
            return response()->json([
                'message' => 'Page not found'
            ], 404);
        }

        return response()->json([
            'data' => $page
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:pages,slug',
            'content' => 'required|string',
            'status' => 'required|in:draft,published',
        ]);

        $page = Page::create($validated);

        return response()->json([
            'data' => $page
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $page = Page::find($id);

        if (!$page) {
            return response()->json([
                'message' => 'Page not found'
            ], 404);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('pages', 'slug')->ignore($page->id),
            ],
            'content' => 'required|string',
            'status' => 'required|in:draft,published',
        ]);

        $page->update($validated);

        return response()->json([
            'data' => $page
        ], 200);
    }

    public function destroy($id)
    {
        $page = Page::find($id);

        if (!$page) {
            return response()->json([
                'message' => 'Page not found'
            ], 404);
        }

        $page->delete();

        return response()->json([
            'message' => 'Page deleted successfully'
        ], 200);
    }
    public function manageIndex()
    {
        $pages = Page::with('contentBlocks')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'data' => $pages
        ], 200);
    }
}
