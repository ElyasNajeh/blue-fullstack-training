<?php

namespace Elyas\Services\Models;

use Model;

class DocumentCategory extends Model
{
    use \October\Rain\Database\Traits\Validation;

    public $table = 'elyas_services_document_categories';

    public $rules = [
        'name' => 'required',
        'slug' => 'required',
        'status' => 'required|in:active,inactive',
        'display_order' => 'required|integer|min:0',
    ];

    public $hasMany = [
        'documents' => [
            Document::class,
            'key' => 'document_category_id'
        ]
    ];

    public function beforeValidate()
    {
        $this->rules['slug'] =
            'required|unique:elyas_services_document_categories,slug,' .
            ($this->id ?? 'NULL') . ',id';
    }
}
