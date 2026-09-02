<?php

namespace Elyas\Services\Models;

use Model;

class PageSection extends Model
{
    use \October\Rain\Database\Traits\Validation;

    public $table = 'elyas_services_page_sections';

    protected $jsonable = ['content'];

    public $rules = [
        'page_id' => 'required',
        'type' => 'required|in:hero,text,image_text,cta',
        'display_order' => 'required|integer|min:0',
        'is_active' => 'boolean',
    ];

    public $belongsTo = [
        'page' => [
            Page::class,
            'key' => 'page_id'
        ]
    ];

    public function getTypeOptions()
    {
        return [
            'hero' => 'Hero / Banner',
            'text' => 'Text Content',
            'image_text' => 'Image + Text',
            'cta' => 'Call to Action (CTA)',
        ];
    }
}
