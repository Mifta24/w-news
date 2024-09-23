<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSedder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::create([
            'title' => 'My First Post',
            'news_content' => 'This is my first post',
            'author_id' => 1
        ]);

        Post::create([
            'title' => 'My Second Post',
            'news_content' => 'This is my second post',
            'author_id' => 1
        ]);
    }
}
