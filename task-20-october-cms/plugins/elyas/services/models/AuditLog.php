<?php

namespace Elyas\Services\Models;

use Model;

class AuditLog extends Model
{
    public $table = 'elyas_services_audit_logs';

    protected $guarded = [];

    protected $jsonable = [
        'metadata'
    ];
}
