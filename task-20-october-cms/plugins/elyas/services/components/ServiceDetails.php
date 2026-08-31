<?php

namespace Elyas\Services\Components;

use Cms\Classes\ComponentBase;
use Elyas\Services\Models\Service;

class ServiceDetails extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Service Details',
            'description' => 'Displays the details of a single service.'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun()
    {
        $serviceId = $this->param('id');

        $service = Service::with(['category', 'image'])
            ->where('id', $serviceId)
            ->where('is_active', true)
            ->whereHas('category', function ($query) {
                $query->where('is_active', true);
            })
            ->first();

        if (!$service) {
            abort(404);
        }

        $this->page['service'] = $service;
    }
}
