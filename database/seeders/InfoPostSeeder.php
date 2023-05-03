<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\InfoPost;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class InfoPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = Post::all();
        foreach ($posts as $post) {
            InfoPost::factory([
                'post_id' => $post->id
            ])->create();
        }
    }
}
