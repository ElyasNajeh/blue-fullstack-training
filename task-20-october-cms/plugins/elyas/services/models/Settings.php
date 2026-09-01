<?php

namespace Elyas\Services\Models;

use Model;

class Settings extends Model
{
    use \October\Rain\Database\Traits\Validation;

    public $implement = [
        \System\Behaviors\SettingsModel::class
    ];

    public $settingsCode = 'elyas_services_settings';

    public $settingsFields = 'fields.yaml';

    public $rules = [
        'contact_email' => 'required|email',
        'phone' => 'required',
        'address' => 'required',
        'help_text' => 'nullable|string',
    ];
}
