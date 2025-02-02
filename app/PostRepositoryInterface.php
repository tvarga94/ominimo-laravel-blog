<?php

namespace App;

use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface PostRepositoryInterface
{
    public function all(): Collection;
    public function find(int $id): Post;
    public function create(array $data): Post;
    public function update(int $id, array $data): Post;
    public function delete(int $id): bool;
    public function paginate(int $perPage): LengthAwarePaginator;
}
