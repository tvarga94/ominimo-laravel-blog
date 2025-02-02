<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_view_posts(): void
    {
        $post = Post::factory()->create();

        $response = $this->get(route('posts.index'));

        $response->assertStatus(200);
        $response->assertSee($post->title);
    }

    public function test_authenticated_user_can_create_post(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('posts.store'), [
                'title' => 'New Post',
                'content' => 'This is a test post.',
            ])
            ->assertRedirect(route('posts.index'))
            ->assertSessionHas('success', 'Post created successfully.');

        $this->assertDatabaseHas('posts', [
            'title' => 'New Post',
            'content' => 'This is a test post.',
            'user_id' => $user->id,
        ]);
    }

    public function test_guest_cannot_create_post(): void
    {
        $response = $this->post(route('posts.store'), [
            'title' => 'Unauthorized Post',
            'content' => 'This should not be allowed.',
        ]);

        $response->assertRedirect(route('login'));
        $this->assertDatabaseMissing('posts', ['title' => 'Unauthorized Post']);
    }

    public function test_post_owner_can_edit_post(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->for($user)->create();

        $this->actingAs($user)
            ->put(route('posts.update', $post->id), [
                'title' => 'Updated Title',
                'content' => 'Updated content.',
            ])
            ->assertRedirect(route('posts.index'))
            ->assertSessionHas('success', 'Post updated successfully.');

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Updated Title',
            'content' => 'Updated content.',
        ]);
    }

    public function test_non_owner_cannot_edit_post(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $post = Post::factory()->for($user1)->create();

        $this->actingAs($user2)
            ->put(route('posts.update', $post->id), [
                'title' => 'Illegal Edit',
                'content' => 'Should not be allowed.',
            ])
            ->assertRedirect(route('posts.index'))
            ->assertSessionHas('error', 'You are not authorized to edit this post.');

        $this->assertDatabaseMissing('posts', ['title' => 'Illegal Edit']);
    }

    public function test_post_owner_can_delete_post(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->for($user)->create();

        $this->actingAs($user)
            ->delete(route('posts.destroy', $post->id))
            ->assertRedirect(route('posts.index'))
            ->assertSessionHas('success', 'Post deleted successfully.');

        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }

    public function test_non_owner_cannot_delete_post(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $post = Post::factory()->for($user1)->create();

        $this->actingAs($user2)
            ->delete(route('posts.destroy', $post->id))
            ->assertRedirect(route('posts.index'))
            ->assertSessionHas('error', 'You are not authorized to delete this post.');

        $this->assertDatabaseHas('posts', ['id' => $post->id]);
    }
}
