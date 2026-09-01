<?php

namespace Elyas\Services\Models;

use Model;

class ContactMessage extends Model
{
    use \October\Rain\Database\Traits\Validation;

    public $table = 'elyas_services_contact_messages';

    public $rules = [
        'name' => 'required|max:255',
        'email' => 'required|email|max:255',
        'subject' => 'required|max:255',
        'message' => 'required',
        'status' => 'required|in:new,read',
    ];

    public function getStatusOptions()
    {
        return [
            'new' => 'New',
            'read' => 'Read',
        ];
    }
}
