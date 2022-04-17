<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Like;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Follow;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(20)->create();
        Post::factory(200)->create();
        Like::factory(500)->create();
        Comment::factory(1000)->create();
        Follow::factory(100)->create();
    }
}
