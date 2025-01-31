<?php

namespace App\Http\Repositories;

use App\Models\Comment;
use App\CommentRepositoryInterface;

class CommentRepository implements CommentRepositoryInterface
{
    public function create(array $data): Comment
    {
        return Comment::create($data);
    }

    public function delete(Comment $comment): bool
    {
        return $comment->delete();
    }
}
