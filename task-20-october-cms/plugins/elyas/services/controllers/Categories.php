<?php

namespace Elyas\Services\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

class Categories extends Controller
{
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class,
    ];

    public $formConfig = 'config_form.yaml';

    public $listConfig = 'config_list.yaml';

    public $requiredPermissions = [
        'elyas.services.categories'
    ];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext(
            'Elyas.Services',
            'services',
            'categories'
        );
    }
}
