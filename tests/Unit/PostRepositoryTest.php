<?php

namespace Tests\Unit;

use App\Http\Repositories\PostRepository;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class PostRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private PostRepository $postRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->postRepository = new PostRepository();
    }

    public function test_can_find_post()
    {
        $post = Post::factory()->create();

        $foundPost = $this->postRepository->find($post->id);

        $this->assertNotNull($foundPost);
        $this->assertEquals($post->id, $foundPost->id);
    }

    public function test_can_create_post()
    {
        $user = User::factory()->create();
        Auth::login($user);

        $data = [
            'title' => 'Test Post',
            'content' => 'This is a test post',
            'user_id' => $user->id,
        ];

        $post = $this->postRepository->create($data);

        $this->assertInstanceOf(Post::class, $post);
        $this->assertEquals('Test Post', $post->title);
    }

    public function test_can_update_post()
    {
        $post = Post::factory()->create();

        $updateData = ['title' => 'Updated Title'];

        $updatedPost = $this->postRepository->update($post->id, $updateData);

        $this->assertEquals('Updated Title', $updatedPost->title);
        $this->assertDatabaseHas('posts', ['id' => $post->id, 'title' => 'Updated Title']);
    }

    public function test_can_delete_post()
    {
        $post = Post::factory()->create();

        $result = $this->postRepository->delete($post->id);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }
}
