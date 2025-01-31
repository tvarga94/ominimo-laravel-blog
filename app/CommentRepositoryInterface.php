<?php

namespace App;

use App\Models\Comment;

interface CommentRepositoryInterface
{
    public function create(array $data): Comment;
    public function delete(Comment $comment): bool;
}
