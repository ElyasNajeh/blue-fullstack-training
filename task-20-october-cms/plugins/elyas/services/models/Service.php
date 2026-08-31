<?php

namespace Elyas\Services\Models;

use Model;
use System\Models\File;

class Service extends Model
{
    use \October\Rain\Database\Traits\Validation;

    public $table = 'elyas_services_services';

    public $rules = [
        'title' => 'required',
        'short_description' => 'required',
        'description' => 'required',
        'category_id' => 'required|exists:elyas_services_categories,id',
        'is_active' => 'boolean',
        'display_order' => 'required|integer|min:0',
    ];

    public $belongsTo = [
        'category' => [
            Category::class,
            'key' => 'category_id'
        ]
    ];

    public $attachOne = [
        'image' => File::class
    ];
}
