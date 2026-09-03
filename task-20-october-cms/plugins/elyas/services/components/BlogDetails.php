<?php

namespace Elyas\Services\Components;

use Cms\Classes\ComponentBase;
use Elyas\Services\Models\BlogPost;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BlogDetails extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Blog Details',
            'description' => 'Displays a single published blog post.'
        ];
    }

    public function onRun()
    {
        $slug = $this->param('slug');

        $post = BlogPost::published()
            ->with(['category', 'featured_image'])
            ->where('slug', $slug)
            ->first();

        if (!$post) {
            throw new NotFoundHttpException();
        }

        $relatedPosts = BlogPost::published()
            ->where('blog_category_id', $post->blog_category_id)
            ->where('id', '!=', $post->id)
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        $this->page['post'] = $post;
        $this->page['relatedPosts'] = $relatedPosts;

        $this->page->title = $post->title;
        $this->page->meta_title = $post->title;
        $this->page->meta_description = $post->excerpt;
    }
}
