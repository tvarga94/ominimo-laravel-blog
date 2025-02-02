<?php

namespace App\Http\Repositories;

use App\Models\Comment;
use App\CommentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CommentRepository implements CommentRepositoryInterface
{
    public function find(int $id): ?Comment
    {
        return Comment::with('post')->find($id);
    }

    public function create(array $data): Comment
    {
        return Comment::create($data);
    }

    public function delete(int $id): bool
    {
        return Comment::destroy($id);
    }

    public function getCommentsByPost(int $postId): Collection
    {
        return Comment::where('post_id', $postId)->latest()->get();
    }
}
