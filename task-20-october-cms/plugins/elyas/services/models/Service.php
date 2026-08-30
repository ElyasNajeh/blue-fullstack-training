<?php

namespace Elyas\Services\Models;

use Model;

/**
 * Service Model
 *
 * @link https://docs.octobercms.com/4.x/extend/system/models.html
 */
class Service extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table name
     */
    public $table = 'elyas_services_services';

    /**
     * @var array rules for validation
     */
    public $rules = [
        'title' => 'required',
        'short_description' => 'required',
        'description' => 'required',
        'is_active' => 'boolean',
        'display_order' => 'required|integer|min:0',
    ];
}
