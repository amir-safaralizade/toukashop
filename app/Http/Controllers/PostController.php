<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        return view('site.pages.posts.index');
    }

    public function show($slug)
    {
        $post = Post::where('slug', $slug)->firstOrfail();
        recordVisit($post);
        return view('site.pages.posts.show', compact('post'));
    }
}
