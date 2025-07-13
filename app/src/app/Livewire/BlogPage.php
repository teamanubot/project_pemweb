<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\BlogPost;

class BlogPage extends Component
{
    public function render()
    {
        $posts = BlogPost::with('author')
            ->where('is_published', true)
            ->orderByDesc('published_at')
            ->get();

        return view('livewire.blog-page', [
            'posts' => $posts,
        ]);
    }
}
    