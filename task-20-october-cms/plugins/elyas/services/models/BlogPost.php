<?php

namespace Elyas\Services\Models;

use Model;
use System\Models\File;

class BlogPost extends Model
{
    use \October\Rain\Database\Traits\Validation;

    public $table = 'elyas_services_blog_posts';

    public $rules = [
        'title' => 'required',
        'slug' => 'required',
        'excerpt' => 'required',
        'content' => 'required',
        'blog_category_id' => 'required|exists:elyas_services_blog_categories,id',
        'status' => 'required|in:draft,published',
        'published_at' => 'nullable|date',
    ];

    public $belongsTo = [
        'category' => [
            BlogCategory::class,
            'key' => 'blog_category_id'
        ]
    ];

    public $attachOne = [
        'featured_image' => File::class
    ];

    public function beforeValidate()
    {
        $this->rules['slug'] =
            'required|unique:elyas_services_blog_posts,slug,' . ($this->id ?? 'NULL') . ',id';
    }

    public function scopePublished($query)
    {
        return $query
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }
}
