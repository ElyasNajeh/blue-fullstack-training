<?php

namespace Elyas\Services\Components;

use Cms\Classes\ComponentBase;
use Elyas\Services\Models\Service;
use Elyas\Services\Models\Category;

class Services extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Services',
            'description' => 'Displays active services ordered by display order.'
        ];
    }

    public function defineProperties()
    {
        return [
            'limit' => [
                'title' => 'Maximum Services',
                'description' => 'Maximum number of services to display.',
                'default' => 10,
                'type' => 'string',
                'validationPattern' => '^[0-9]+$',
                'validationMessage' => 'The limit must be a number.'
            ]
        ];
    }

    public function onRun()
    {
        $limit = (int) $this->property('limit');
        $selectedCategory = get('category');

        $categories = Category::where('is_active', true)
            ->orderBy('display_order', 'asc')
            ->get();

        $servicesQuery = Service::with(['category', 'image'])
            ->where('is_active', true)
            ->whereHas('category', function ($query) {
                $query->where('is_active', true);
            });

        if ($selectedCategory) {
            $servicesQuery->whereHas('category', function ($query) use ($selectedCategory) {
                $query->where('slug', $selectedCategory);
            });
        }

        $services = $servicesQuery
            ->orderBy('display_order', 'asc')
            ->take($limit)
            ->get();

        $this->page['categories'] = $categories;
        $this->page['services'] = $services;
        $this->page['selectedCategory'] = $selectedCategory;
    }
}
