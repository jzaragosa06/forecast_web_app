<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Auth;


class PostController extends Controller
{
    // Display the post creation form
    public function create()
    {
        return view('posts.create');
    }

    // Store a new post
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        Post::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'body' => $request->body,
        ]);

        return redirect()->route('posts.index');
    }

    // Show a specific post and its comments
    public function show($id)
    {
        $post = Post::with(['user', 'comments.replies.user'])->findOrFail($id);

        return view('posts.show', compact('post'));
    }

    // Display all posts
    // public function index()
    // {
    //     $posts = Post::with('user')->latest()->get();

    //     return view('posts.index', compact('posts'));
    // }
        public function index()
    {
        // Get the currently authenticated user ID
        $currentUserId = Auth::id();

        // Separate posts made by the current user and others
        $myPosts = Post::where('user_id', $currentUserId)->latest()->get();
        $otherPosts = Post::where('user_id', '!=', $currentUserId)->latest()->get();

        // Pass both collections to the view
        return view('posts.index', compact('myPosts', 'otherPosts'));
    }
}