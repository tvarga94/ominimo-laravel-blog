<?php

namespace App\Http\Controllers;

use App\CommentRepositoryInterface;
use App\Http\Requests\StoreCommentRequest;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    use AuthorizesRequests;
    private CommentRepositoryInterface $commentRepository;

    public function __construct(CommentRepositoryInterface $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function store(StoreCommentRequest $request, int $id): RedirectResponse
    {
        $post = Post::findOrFail($id);

        $this->commentRepository->create([
            'post_id' => $post->id,
            'user_id' => Auth::id() ?? null,
            'comment' => $request->comment,
        ]);

        return redirect()->route('posts.show', $post->id)->with('success', 'Comment added successfully.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $comment = $this->commentRepository->find($id);

        if (!$comment) {
            return redirect()->back()->with('error', 'Comment not found.');
        }

        try {
            $this->authorize('delete', $comment);
        } catch (AuthorizationException $e) {
            return redirect()->route('posts.show', $comment->post_id)->with('error', 'You are not authorized to delete this comment.');
        }

        $this->commentRepository->delete($id);

        return redirect()->back()->with('success', 'Comment deleted successfully.');
    }
}
