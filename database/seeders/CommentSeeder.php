<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $firstUser = User::where('role', NULL)->first();

        foreach (Post::all() as $post) {
            Comment::factory(2)->create([
                'post_id' => $post->id,
                'user_id' => $firstUser->id,
            ]);
        }
    }
}
