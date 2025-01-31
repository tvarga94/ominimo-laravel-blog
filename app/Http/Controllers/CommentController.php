<?php

namespace App\Http\Controllers;

use App\CommentRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;


class CommentController extends Controller
{
    private CommentRepositoryInterface $commentRepository;

    public function __construct(CommentRepositoryInterface $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function store(StoreCommentRequest $request, Post $post)
    {
        $request->validate([
            'comment' => 'required|string|max:500',
        ]);

        $this->commentRepository->create([
            'post_id' => $post->id,
            'user_id' => auth()->id() ?? null,
            'comment' => $request->validated()['comment'],
        ]);

        return redirect()->back()->with('success', 'Comment added!');
    }

    public function destroy(DeleteCommentRequest $request, Comment $comment)
    {
        if (auth()->id() !== $comment->user_id && auth()->id() !== $comment->post->user_id) {
            abort(403, 'Unauthorized');
        }

        $this->commentRepository->delete($comment);

        return redirect()->back()->with('success', 'Comment deleted!');
    }
}
