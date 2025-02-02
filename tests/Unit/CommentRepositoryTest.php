<?php

namespace Tests\Unit;

use App\Http\Repositories\CommentRepository;
use App\Models\Comment;
use App\Models\Post;
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
}
