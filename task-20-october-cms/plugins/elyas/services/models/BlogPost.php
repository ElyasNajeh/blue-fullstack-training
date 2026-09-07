<?php

namespace Elyas\Services\Models;

use Model;
use System\Models\File;
use Elyas\Services\Classes\AuditLogger;

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
    protected $originalStatus;

    public function beforeUpdate()
    {
        $this->originalStatus = $this->getOriginal('status');
    }

    public function afterCreate()
    {
        AuditLogger::log(
            'Create',
            'Blog Post',
            $this,
            "Created blog post: {$this->title}"
        );
    }

    public function afterUpdate()
    {
        AuditLogger::log(
            'Update',
            'Blog Post',
            $this,
            "Updated blog post: {$this->title}"
        );

        if ($this->originalStatus !== $this->status) {
            AuditLogger::log(
                'Status Change',
                'Blog Post',
                $this,
                "Changed blog post status from {$this->originalStatus} to {$this->status}",
                [
                    'old_status' => $this->originalStatus,
                    'new_status' => $this->status,
                ]
            );
        }
    }

    public function afterDelete()
    {
        AuditLogger::log(
            'Delete',
            'Blog Post',
            $this,
            "Deleted blog post: {$this->title}"
        );
    }
}
