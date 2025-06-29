<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BlogPost;
use App\Models\User;

class BlogPostsTableSeeder extends Seeder
{
    public function run()
    {
        BlogPost::create([
            'title' => 'Welcome to the Platform',
            'slug' => 'welcome-to-the-platform',
            'content' => 'Konten blog pertama.',
            'author_id' => User::first()->id,
            'published_at' => now(),
            'is_published' => true
        ]);
    }
}
