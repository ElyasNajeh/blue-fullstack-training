<?php

namespace Elyas\Services\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Elyas\Services\Models\AuditLog;

class AuditLogs extends Controller
{
    public $implement = [
        \Backend\Behaviors\ListController::class
    ];

    public $listConfig = 'config_list.yaml';

    public $requiredPermissions = [
        'elyas.services.audit_logs'
    ];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext(
            'Elyas.Services',
            'services',
            'audit_logs'
        );
    }

    public function view($id)
    {
        $this->pageTitle = 'Audit Log Details';

        $auditLog = AuditLog::findOrFail($id);

        $this->vars['auditLog'] = $auditLog;
    }
}
