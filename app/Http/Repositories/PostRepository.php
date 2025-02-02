<?php

namespace App\Http\Repositories;

use App\Models\Post;
use App\PostRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class PostRepository implements PostRepositoryInterface
{
    public function all(): Collection
    {
        return Post::all();
    }

    public function find(int $id): Post
    {
        return Post::findOrFail($id);
    }

    public function create(array $data): Post
    {
        return Post::create($data);
    }

    public function update(int $id, array $data): Post
    {
        $post = Post::findOrFail($id);
        $post->update($data);
        return $post;
    }

    public function delete(int $id): bool
    {
        return Post::destroy($id);
    }

    public function paginate(int $perPage): LengthAwarePaginator
    {
        return Post::latest()->paginate($perPage);
    }
}
