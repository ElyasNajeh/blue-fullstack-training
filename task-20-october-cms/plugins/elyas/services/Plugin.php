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
            \Elyas\Services\Components\ContactForm::class => 'contactForm',
            \Elyas\Services\Components\DynamicPage::class => 'dynamicPage',
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

            'elyas.services.contact_messages' => [
                'tab' => 'Services',
                'label' => 'Manage Contact Messages'
            ],

            'elyas.services.pages' => [
                'tab' => 'Services',
                'label' => 'Manage Dynamic Pages'
            ],
        ];
    }

    public function registerSettings()
    {
        return [
            'contact_settings' => [
                'label' => 'Contact Settings',
                'description' => 'Manage website contact information.',
                'category' => 'Services',
                'icon' => 'icon-envelope',
                'class' => \Elyas\Services\Models\Settings::class,
                'order' => 500,
                'keywords' => 'contact email phone address',
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

                    'contact_messages' => [
                        'label' => 'Contact Messages',
                        'url' => Backend::url('elyas/services/contactmessages'),
                        'icon' => 'icon-envelope',
                        'permissions' => ['elyas.services.contact_messages'],
                    ],

                    'pages' => [
                        'label' => 'Dynamic Pages',
                        'url' => Backend::url('elyas/services/pages'),
                        'icon' => 'icon-file-text-o',
                        'permissions' => ['elyas.services.pages'],
                    ],
                ],
            ],
        ];
    }
}
