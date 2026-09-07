<?php

namespace Elyas\Services\Models;

use Model;
use System\Models\File;
use ValidationException;
use Elyas\Services\Classes\AuditLogger;

class Document extends Model
{
    use \October\Rain\Database\Traits\Validation;

    public $table = 'elyas_services_documents';

    protected $originalStatus;

    public $rules = [
        'title' => 'required',
        'slug' => 'required',
        'description' => 'required',
        'document_category_id' => 'required|exists:elyas_services_document_categories,id',
        'status' => 'required|in:draft,published',
        'published_at' => 'nullable|date',
    ];

    public $belongsTo = [
        'category' => [
            DocumentCategory::class,
            'key' => 'document_category_id'
        ]
    ];

    public $attachOne = [
        'file' => File::class
    ];

    public function beforeValidate()
    {
        $this->rules['slug'] =
            'required|unique:elyas_services_documents,slug,' .
            ($this->id ?? 'NULL') . ',id';
    }

    public function beforeSave()
    {
        $this->validateDocumentFile();
    }

    protected function validateDocumentFile()
    {
        // October CMS may attach the file after the model is initially saved.
        if (!$this->file) {
            return;
        }

        $allowedExtensions = [
            'pdf',
            'doc',
            'docx',
            'xls',
            'xlsx',
            'ppt',
            'pptx'
        ];

        $extension = strtolower($this->file->getExtension());

        if (!in_array($extension, $allowedExtensions)) {
            throw new ValidationException([
                'file' => 'Unsupported file type. Allowed types: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX.'
            ]);
        }

        // Maximum file size: 10 MB
        $maxFileSize = 10 * 1024 * 1024;

        if ($this->file->file_size > $maxFileSize) {
            throw new ValidationException([
                'file' => 'The document file must not exceed 10 MB.'
            ]);
        }
    }

    public function scopePublished($query)
    {
        return $query
            ->where('status', 'published')
            ->where(function ($query) {
                $query
                    ->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            });
    }

    /*
    |--------------------------------------------------------------------------
    | Audit Logging
    |--------------------------------------------------------------------------
    */

    public function beforeUpdate()
    {
        $this->originalStatus = $this->getOriginal('status');
    }

    public function afterCreate()
    {
        AuditLogger::log(
            'Create',
            'Document',
            $this,
            "Created document: {$this->title}"
        );
    }

    public function afterUpdate()
    {
        AuditLogger::log(
            'Update',
            'Document',
            $this,
            "Updated document: {$this->title}"
        );

        if ($this->originalStatus !== $this->status) {
            AuditLogger::log(
                'Status Change',
                'Document',
                $this,
                "Changed document status from {$this->originalStatus} to {$this->status}",
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
            'Document',
            $this,
            "Deleted document: {$this->title}"
        );
    }
}
