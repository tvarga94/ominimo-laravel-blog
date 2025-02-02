<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    //@TODO: isAdmin ijn User model
    public function update(User $user, Post $post): bool
    {
        return $user->role === 'admin' || $user->id === $post->user_id;
    }

    public function delete(User $user, Post $post): bool
    {
        return $user->role === 'admin' || $user->id === $post->user_id;
    }
}
