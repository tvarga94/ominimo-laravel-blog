<?php

namespace Tests\Unit;

use App\Http\Repositories\CommentRepository;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private CommentRepository $commentRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->commentRepository = new CommentRepository();
    }

    public function test_can_find_comment()
    {
        $post = Post::factory()->create();
        $comment = Comment::factory()->create(['post_id' => $post->id]);

        $foundComment = $this->commentRepository->find($comment->id);

        $this->assertNotNull($foundComment);
        $this->assertEquals($comment->id, $foundComment->id);
    }

    public function test_returns_null_if_comment_does_not_exist()
    {
        $this->assertNull($this->commentRepository->find(9999));
    }

    public function test_can_create_comment()
    {
        $post = Post::factory()->create();
        $user = User::factory()->create();

        $data = [
            'post_id' => $post->id,
            'user_id' => $user->id,
            'comment' => 'This is a test comment.',
        ];

        $comment = $this->commentRepository->create($data);

        $this->assertDatabaseHas('comments', $data);
        $this->assertEquals($data['comment'], $comment->comment);
    }

    public function test_can_delete_comment()
    {
        $comment = Comment::factory()->create();

        $result = $this->commentRepository->delete($comment->id);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
    }
}
