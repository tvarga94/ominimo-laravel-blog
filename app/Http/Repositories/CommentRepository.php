<?php

namespace App\Http\Repositories;

use App\Models\Comment;
use App\CommentRepositoryInterface;

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
        return Comment::where('id', $id)->delete();
    }
}
