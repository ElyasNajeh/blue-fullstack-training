<?php

namespace Elyas\Services\Models;

use Model;

class Page extends Model
{
    use \October\Rain\Database\Traits\Validation;

    public $table = 'elyas_services_pages';

    public $rules = [
        'title' => 'required|max:255',
        'slug' => 'required',
        'status' => 'required|in:published,draft',
        'seo_title' => 'nullable|max:255',
        'seo_description' => 'nullable',
    ];

    public function beforeValidate()
    {
        $this->rules['slug'] =
            'required|unique:elyas_services_pages,slug,' . ($this->id ?? 'NULL') . ',id';
    }

    public function getStatusOptions()
    {
        return [
            'published' => 'Published',
            'draft' => 'Draft',
        ];
    }
    public $hasMany = [
        'sections' => [
            PageSection::class,
            'key' => 'page_id',
            'order' => 'display_order asc'
        ]
    ];
}
