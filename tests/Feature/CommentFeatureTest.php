<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_comment_on_post(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $this->actingAs($user)
            ->post(route('comments.store', $post->id), [
                'comment' => 'This is a test comment.',
            ])
            ->assertRedirect(route('posts.show', $post->id))
            ->assertSessionHas('success', 'Comment added successfully.');

        $this->assertDatabaseHas('comments', [
            'post_id' => $post->id,
            'user_id' => $user->id,
            'comment' => 'This is a test comment.',
        ]);
    }

    public function test_guest_can_comment_on_post(): void
    {
        $post = Post::factory()->create();

        $this->post(route('comments.store', $post->id), [
            'comment' => 'Guest comment.',
        ])
            ->assertRedirect(route('posts.show', $post->id))
            ->assertSessionHas('success', 'Comment added successfully.');

        $this->assertDatabaseHas('comments', [
            'post_id' => $post->id,
            'user_id' => null,
            'comment' => 'Guest comment.',
        ]);
    }

    public function test_comment_owner_can_delete_comment(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        $comment = Comment::factory()->for($post)->for($user)->create();

        $this->actingAs($user)
            ->delete(route('comments.destroy', $comment->id))
            ->assertRedirect()
            ->assertSessionHas('success', 'Comment deleted successfully.');

        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
    }

    public function test_post_owner_can_delete_any_comment_on_their_post(): void
    {
        $postOwner = User::factory()->create();
        $commenter = User::factory()->create();
        $post = Post::factory()->for($postOwner)->create();
        $comment = Comment::factory()->for($post)->for($commenter)->create();

        $this->actingAs($postOwner)
            ->delete(route('comments.destroy', $comment->id))
            ->assertRedirect()
            ->assertSessionHas('success', 'Comment deleted successfully.');

        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
    }

    public function test_non_owner_cannot_delete_comment(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $post = Post::factory()->create();
        $comment = Comment::factory()->for($post)->for($user1)->create();

        $this->actingAs($user2)
            ->delete(route('comments.destroy', $comment->id))
            ->assertRedirect()
            ->assertSessionHas('error', 'You are not authorized to delete this comment.');

        $this->assertDatabaseHas('comments', ['id' => $comment->id]);
    }
}
