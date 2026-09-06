<?php

namespace Elyas\Services\Models;

use Model;
use System\Models\File;
use ValidationException;

class Document extends Model
{
    use \October\Rain\Database\Traits\Validation;

    public $table = 'elyas_services_documents';

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
        if (!$this->file) {
            throw new ValidationException([
                'file' => 'A document file is required.'
            ]);
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
}
