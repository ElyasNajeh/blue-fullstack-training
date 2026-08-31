<?php

namespace Elyas\Services;

use Backend;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function pluginDetails()
    {
        return [
            'name' => 'Services',
            'description' => 'Manage and display website services.',
            'author' => 'Elyas',
            'icon' => 'icon-leaf'
        ];
    }

    public function register()
    {
        //
    }

    public function boot()
    {
        //
    }

    public function registerComponents()
    {
        return [
            \Elyas\Services\Components\Services::class => 'services',
            \Elyas\Services\Components\ServiceDetails::class => 'serviceDetails',
        ];
    }

    public function registerPermissions()
    {
        return [
            'elyas.services.services' => [
                'tab' => 'Services',
                'label' => 'Manage Services'
            ],

            'elyas.services.categories' => [
                'tab' => 'Services',
                'label' => 'Manage Categories'
            ],
        ];
    }

    public function registerNavigation()
    {
        return [
            'services' => [
                'label' => 'Services',
                'url' => Backend::url('elyas/services/services'),
                'icon' => 'icon-leaf',
                'permissions' => ['elyas.services.*'],
                'order' => 500,

                'sideMenu' => [
                    'services' => [
                        'label' => 'Services',
                        'url' => Backend::url('elyas/services/services'),
                        'icon' => 'icon-list',
                        'permissions' => ['elyas.services.services'],
                    ],

                    'categories' => [
                        'label' => 'Categories',
                        'url' => Backend::url('elyas/services/categories'),
                        'icon' => 'icon-folder',
                        'permissions' => ['elyas.services.categories'],
                    ],
                ],
            ],
        ];
    }
}
