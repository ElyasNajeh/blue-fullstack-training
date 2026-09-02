<?php

namespace Elyas\Services\Components;

use Cms\Classes\ComponentBase;
use Elyas\Services\Models\Page;

class DynamicPage extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Dynamic Page',
            'description' => 'Displays a published dynamic page by slug.'
        ];
    }

    public function onRun()
    {
        $slug = $this->param('slug');

        $page = Page::with([
            'sections' => function ($query) {
                $query
                    ->where('is_active', true)
                    ->orderBy('display_order', 'asc');
            }
        ])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->first();

        if (!$page) {
            abort(404);
        }

        $this->page['dynamicPage'] = $page;

        $this->page->title = $page->seo_title ?: $page->title;

        if ($page->seo_description) {
            $this->page->meta_description = $page->seo_description;
        }
    }
}
