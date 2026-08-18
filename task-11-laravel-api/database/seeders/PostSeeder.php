<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        Post::create([
            'title' => 'Introduction to Laravel',
            'body' => 'This is a sample post about Laravel basics.',
            'status' => 'published',
            'category_id' => 1,
        ]);

        Post::create([
            'title' => 'Learning Eloquent',
            'body' => 'This is a sample post about Laravel Eloquent ORM.',
            'status' => 'draft',
            'category_id' => 1,
        ]);

        Post::create([
            'title' => 'Building REST APIs',
            'body' => 'This is a sample post about building REST APIs with Laravel.',
            'status' => 'published',
            'category_id' => 1,
        ]);

        Post::create([
            'title' => 'Request Validation',
            'body' => 'This is a sample post about validating API requests.',
            'status' => 'draft',
            'category_id' => 3,
        ]);

        Post::create([
            'title' => 'Laravel Migrations',
            'body' => 'This is a sample post about managing database structure with migrations.',
            'status' => 'published',
            'category_id' => 3,
        ]);
    }
}
