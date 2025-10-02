<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::Orderby('id', 'desc')->get();
        return view('site.pages.posts.index', compact('posts'));
    }

    public function show($slug)
    {
        $post = Post::where('slug', $slug)->firstOrfail();
        recordVisit($post);
        return view('site.pages.posts.show', compact('post'));
    }

    public function tag(Request $request, $slug)
    {
        $tag = Tag::where('slug', $slug)->firstOrfail();
        $posts = $tag->posts()->orderby('id', 'desc')->get();
        return view('site.pages.post_tags', compact('posts', 'tag'));
    }
}
