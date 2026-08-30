<?php

namespace Elyas\Services\Components;

use Cms\Classes\ComponentBase;
use Elyas\Services\Models\Service;

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

        $this->page['services'] = Service::where('is_active', true)
            ->orderBy('display_order', 'asc')
            ->take($limit)
            ->get();
    }
}
