<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\ContentBlock;
use Illuminate\Http\Request;

class ContentBlockController extends Controller
{
    public function store(Request $request, $pageId)
    {
        $page = Page::findOrFail($pageId);

        $validated = $request->validate([
            'type' => 'required|in:hero,text,cta,feature_list',
            'position' => 'required|integer|min:0',
            'data' => 'required|array',
        ]);

        $block = $page->contentBlocks()->create($validated);

        return response()->json([
            'data' => $block
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $block = ContentBlock::findOrFail($id);

        $validated = $request->validate([
            'type' => 'required|in:hero,text,cta,feature_list',
            'position' => 'required|integer|min:0',
            'data' => 'required|array',
        ]);

        $block->update($validated);

        return response()->json([
            'data' => $block
        ], 200);
    }

    public function destroy($id)
    {
        $block = ContentBlock::findOrFail($id);

        $block->delete();

        return response()->json([
            'message' => 'Block deleted successfully'
        ], 200);
    }

    public function reorder(Request $request, $pageId)
    {
        $page = Page::findOrFail($pageId);

        $validated = $request->validate([
            'blocks' => 'required|array',
            'blocks.*.id' => 'required|integer',
            'blocks.*.position' => 'required|integer|min:0',
        ]);

        foreach ($validated['blocks'] as $item) {
            $page->contentBlocks()
                ->where('id', $item['id'])
                ->update([
                    'position' => $item['position']
                ]);
        }

        return response()->json([
            'message' => 'Blocks reordered successfully'
        ], 200);
    }
}
