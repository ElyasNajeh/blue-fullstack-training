<?php

namespace Elyas\Services\Components;

use Cms\Classes\ComponentBase;
use Elyas\Services\Models\Document;
use Elyas\Services\Models\DocumentCategory;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DocumentLibrary extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Document Library',
            'description' => 'Displays published documents with search, filtering and pagination.'
        ];
    }

    public function onRun()
    {
        $search = trim((string) input('search'));
        $category = trim((string) input('category'));

        $query = Document::published()
            ->with(['category', 'file'])
            ->orderByDesc('published_at');

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($category !== '') {
            $query->whereHas('category', function ($q) use ($category) {
                $q->where('slug', $category);
            });
        }

        $this->page['documents'] = $query
            ->paginate(6)
            ->appends([
                'search' => $search,
                'category' => $category,
            ]);

        $this->page['documentCategories'] = DocumentCategory::query()
            ->where('status', 'active')
            ->orderBy('display_order')
            ->get();

        $this->page['search'] = $search;
        $this->page['selectedCategory'] = $category;
    }

    public function onDownload()
    {
        $documentId = input('document_id');

        $document = Document::published()
            ->with('file')
            ->find($documentId);

        if (!$document || !$document->file) {
            throw new NotFoundHttpException();
        }

        $document->increment('download_count');

        return response()->download(
            $document->file->getLocalPath(),
            $document->file->file_name
        );
    }
}
