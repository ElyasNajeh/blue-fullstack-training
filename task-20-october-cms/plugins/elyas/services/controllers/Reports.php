<?php

namespace Elyas\Services\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Elyas\Services\Models\AuditLog;

class Reports extends Controller
{
    public $requiredPermissions = [
        'elyas.services.reports'
    ];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext(
            'Elyas.Services',
            'services',
            'reports'
        );
    }

    public function index()
    {
        $this->pageTitle = 'Reports';

        $dateFrom = trim((string) input('date_from'));
        $dateTo = trim((string) input('date_to'));
        $module = trim((string) input('module'));
        $action = trim((string) input('action'));

        $query = $this->buildReportQuery(
            $dateFrom,
            $dateTo,
            $module,
            $action
        );

        // Summary
        $this->vars['totalResults'] = (clone $query)->count();

        $this->vars['createCount'] = (clone $query)
            ->where('action', 'Create')
            ->count();

        $this->vars['updateCount'] = (clone $query)
            ->where('action', 'Update')
            ->count();

        $this->vars['deleteCount'] = (clone $query)
            ->where('action', 'Delete')
            ->count();

        // Detailed report
        $this->vars['logs'] = $query
            ->orderByDesc('created_at')
            ->paginate(10)
            ->appends([
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
                'module' => $module,
                'action' => $action,
            ]);

        // Current filters
        $this->vars['dateFrom'] = $dateFrom;
        $this->vars['dateTo'] = $dateTo;
        $this->vars['selectedModule'] = $module;
        $this->vars['selectedAction'] = $action;

        // Filter options
        $this->vars['modules'] = AuditLog::query()
            ->whereNotNull('module')
            ->distinct()
            ->orderBy('module')
            ->pluck('module');

        $this->vars['actions'] = AuditLog::query()
            ->whereNotNull('action')
            ->distinct()
            ->orderBy('action')
            ->pluck('action');
    }

    protected function buildReportQuery(
        string $dateFrom = '',
        string $dateTo = '',
        string $module = '',
        string $action = ''
    ) {
        $query = AuditLog::query();

        if ($dateFrom !== '') {
            $query->whereDate('created_at', '>=', $dateFrom);
        }

        if ($dateTo !== '') {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        if ($module !== '') {
            $query->where('module', $module);
        }

        if ($action !== '') {
            $query->where('action', $action);
        }

        return $query;
    }

    public function export()
    {
        $dateFrom = trim((string) input('date_from'));
        $dateTo = trim((string) input('date_to'));
        $module = trim((string) input('module'));
        $action = trim((string) input('action'));

        $logs = $this->buildReportQuery(
            $dateFrom,
            $dateTo,
            $module,
            $action
        )
            ->orderByDesc('created_at')
            ->get();

        $filename = 'administrative-activity-report-' .
            now()->format('Y-m-d-His') .
            '.csv';

        return response()->streamDownload(function () use ($logs) {

            $handle = fopen('php://output', 'w');

            // UTF-8 BOM for Excel
            fwrite($handle, "\xEF\xBB\xBF");

            fputcsv($handle, [
                'Date / Time',
                'User',
                'Action',
                'Module',
                'Record ID',
                'Description',
            ]);

            foreach ($logs as $log) {
                fputcsv($handle, [
                    $log->created_at,
                    $log->backend_user_name ?: 'Unknown',
                    $log->action,
                    $log->module,
                    $log->record_id,
                    $log->description,
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}
