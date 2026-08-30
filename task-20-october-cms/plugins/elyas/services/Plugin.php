<?php

namespace Elyas\Services;

use Backend;
use System\Classes\PluginBase;

/**
 * Services Plugin
 */
class Plugin extends PluginBase
{
    /**
     * Plugin details.
     */
    public function pluginDetails()
    {
        return [
            'name' => 'Services',
            'description' => 'Manage and display website services.',
            'author' => 'Elyas',
            'icon' => 'icon-leaf'
        ];
    }

    /**
     * Register plugin.
     */
    public function register()
    {
        //
    }

    /**
     * Boot plugin.
     */
    public function boot()
    {
        //
    }

    /**
     * Register frontend components.
     */
    public function registerComponents()
    {
        return [
            \Elyas\Services\Components\Services::class => 'services',
        ];
    }

    /**
     * Register backend permissions.
     */
    public function registerPermissions()
    {
        return [
            'elyas.services.services' => [
                'tab' => 'Services',
                'label' => 'Manage Services'
            ],
        ];
    }

    /**
     * Register backend navigation.
     */
    public function registerNavigation()
    {
        return [
            'services' => [
                'label' => 'Services',
                'url' => Backend::url('elyas/services/services'),
                'icon' => 'icon-leaf',
                'permissions' => ['elyas.services.services'],
                'order' => 500,
            ],
        ];
    }
}
