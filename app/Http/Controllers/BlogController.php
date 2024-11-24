<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Waynelogic\FilamentBlog\Models\Post;

class BlogController extends Controller
{
    public function index()
    {
        $obPost = Post::query()->first();

        return redirect()->route('blog.show', $obPost->slug);
    }

    public function show($slug)
    {
        $obPost = Post::query()->where('slug', $slug)->first();

        $arNavPosts = Post::query()->get();
        if (!$obPost) {
            abort(404);
        }
        return Inertia::render('Blog/Post', [
            'post' => $obPost,
            'navPosts' => $arNavPosts
        ]);
    }
}
