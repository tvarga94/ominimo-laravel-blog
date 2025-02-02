<?php

namespace App\Http\Repositories;

use App\Models\Post;
use App\PostRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class PostRepository implements PostRepositoryInterface
{
    public function all(): Collection
    {
        return Post::with(['user', 'comments'])->latest()->get();
    }

    public function find(int $id): Post
    {
        return Post::with(['user', 'comments'])->findOrFail($id);
    }

    public function create(array $data): Post
    {
        return Auth::user()->posts()->create($data);
    }

    public function update(int $id, array $data): Post
    {
        $post = $this->find($id);
        $post->update($data);
        return $post;
    }

    public function delete(int $id): bool
    {
        return Auth::user()->posts()->where('id', $id)->delete();
    }

    public function paginate(int $perPage): LengthAwarePaginator
    {
        return Post::with(['user', 'comments'])->latest()->paginate($perPage);
    }
}
