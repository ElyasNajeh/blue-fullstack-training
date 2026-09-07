<?php

namespace Elyas\Services\Classes;

use BackendAuth;
use Elyas\Services\Models\AuditLog;

class AuditLogger
{
    public static function log(
        string $action,
        string $module,
        $record,
        string $description,
        array $metadata = []
    ): void {
        $user = BackendAuth::getUser();

        $log = new AuditLog();

        $log->backend_user_id = $user?->id;
        $log->backend_user_name = $user?->login;
        $log->action = $action;
        $log->module = $module;
        $log->record_id = $record->id ?? null;
        $log->description = $description;
        $log->metadata = $metadata ?: null;

        $log->save();
    }
}
