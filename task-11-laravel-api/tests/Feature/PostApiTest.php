<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostApiTest extends TestCase
{
    use RefreshDatabase;

    /*
    |--------------------------------------------------------------------------
    | Login
    |--------------------------------------------------------------------------
    */

    public function test_user_can_login_successfully(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'token',
                'user',
            ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Unauthenticated Access
    |--------------------------------------------------------------------------
    */

    public function test_unauthenticated_user_cannot_create_post(): void
    {
        $response = $this->postJson('/api/posts', [
            'title' => 'Test Post',
            'body' => 'Test Body',
            'status' => 'published',
            'category_id' => 1,
        ]);

        $response->assertStatus(401);
    }

    /*
    |--------------------------------------------------------------------------
    | Authenticated Post Creation
    |--------------------------------------------------------------------------
    */

    public function test_authenticated_user_can_create_post(): void
    {
        $user = User::factory()->create();

        $category = Category::create([
            'name' => 'Technology',
            'slug' => 'technology',
        ]);

        $response = $this
            ->actingAs($user, 'sanctum')
            ->postJson('/api/posts', [
                'title' => 'Laravel Testing',
                'body' => 'Testing post creation.',
                'status' => 'published',
                'category_id' => $category->id,
            ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('posts', [
            'title' => 'Laravel Testing',
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Validation
    |--------------------------------------------------------------------------
    */

    public function test_post_creation_fails_with_invalid_data(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user, 'sanctum')
            ->postJson('/api/posts', [
                'title' => '',
                'body' => '',
                'status' => 'invalid-status',
                'category_id' => 999,
            ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'title',
                'body',
                'status',
                'category_id',
            ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Authorization
    |--------------------------------------------------------------------------
    */

    public function test_user_cannot_update_another_users_post(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();

        $category = Category::create([
            'name' => 'Technology',
            'slug' => 'technology',
        ]);

        $post = $owner->posts()->create([
            'title' => 'Owner Post',
            'body' => 'Original body',
            'status' => 'published',
            'category_id' => $category->id,
        ]);

        $response = $this
            ->actingAs($otherUser, 'sanctum')
            ->putJson("/api/posts/{$post->id}", [
                'title' => 'Changed Title',
                'body' => 'Changed body',
                'status' => 'draft',
                'category_id' => $category->id,
            ]);

        $response->assertStatus(403);

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Owner Post',
        ]);
    }

    public function test_user_cannot_delete_another_users_post(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();

        $category = Category::create([
            'name' => 'Business',
            'slug' => 'business',
        ]);

        $post = $owner->posts()->create([
            'title' => 'Protected Post',
            'body' => 'This belongs to another user.',
            'status' => 'published',
            'category_id' => $category->id,
        ]);

        $response = $this
            ->actingAs($otherUser, 'sanctum')
            ->deleteJson("/api/posts/{$post->id}");

        $response->assertStatus(403);

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Posts List
    |--------------------------------------------------------------------------
    */

    public function test_posts_list_returns_successful_response(): void
    {
        $response = $this->getJson('/api/posts');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data',
                'links',
                'meta',
            ]);
    }
}
