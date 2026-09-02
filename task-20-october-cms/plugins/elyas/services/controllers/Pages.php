<?php

namespace Elyas\Services\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

class Pages extends Controller
{
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class,
        \Backend\Behaviors\RelationController::class,
    ];

    public $formConfig = 'config_form.yaml';

    public $listConfig = 'config_list.yaml';

    public $relationConfig = 'config_relation.yaml';

    public $requiredPermissions = [
        'elyas.services.pages'
    ];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext(
            'Elyas.Services',
            'services',
            'pages'
        );
    }
}
