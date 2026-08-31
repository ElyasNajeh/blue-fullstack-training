<?php

namespace Elyas\Services\Models;

use Model;

class Category extends Model
{
    use \October\Rain\Database\Traits\Validation;

    public $table = 'elyas_services_categories';

    public $rules = [
        'name' => 'required',
        'slug' => 'required',
        'is_active' => 'boolean',
        'display_order' => 'required|integer|min:0',
    ];

    public $hasMany = [
        'services' => [
            Service::class,
            'key' => 'category_id'
        ]
    ];

    public function beforeValidate()
    {
        $this->rules['slug'] =
            'required|unique:elyas_services_categories,slug,' . ($this->id ?? 'NULL') . ',id';
    }
}
