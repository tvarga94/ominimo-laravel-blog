<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('role', NULL)->get();

        foreach ($users as $user) {
            Post::factory(4)->create([
                'user_id' => $user->id,
            ]);
        }
    }
}
