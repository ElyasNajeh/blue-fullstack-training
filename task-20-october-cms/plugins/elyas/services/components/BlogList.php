<?php

namespace Elyas\Services\Components;

use Cms\Classes\ComponentBase;
use Elyas\Services\Models\BlogPost;
use Elyas\Services\Models\BlogCategory;

class BlogList extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Blog List',
            'description' => 'Displays published blog posts.'
        ];
    }

    public function onRun()
    {
        $search = trim((string) input('search'));
        $category = trim((string) input('category'));

        $query = BlogPost::published()
            ->with(['category', 'featured_image'])
            ->orderByDesc('published_at');

        // Search
        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Category Filter
        if ($category !== '') {
            $query->whereHas('category', function ($q) use ($category) {
                $q->where('slug', $category);
            });
        }

        // Posts + Pagination
        $this->page['posts'] = $query
            ->paginate(6)
            ->appends([
                'search' => $search,
                'category' => $category
            ]);

        // Categories
        $this->page['categories'] = BlogCategory::query()
            ->orderBy('display_order')
            ->get();

        // Keep current filters
        $this->page['search'] = $search;
        $this->page['selectedCategory'] = $category;
    }
}
