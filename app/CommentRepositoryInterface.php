<?php

namespace App;

use App\Models\Comment;

interface CommentRepositoryInterface
{
    public function find(int $id): ?Comment;
    public function create(array $data): Comment;
    public function delete(int $id): bool;
}
