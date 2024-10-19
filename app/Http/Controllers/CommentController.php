<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Auth;

class CommentController extends Controller
{
    // Store a new comment or reply
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'body' => 'required|string',
    //         'post_id' => 'required_without:parent_id|exists:posts,id',
    //         'parent_id' => 'nullable|exists:comments,id',
    //     ]);

    //     Comment::create([
            
    //         'user_id' => Auth::id(),
    //         'post_id' => $request->post_id,
    //         'parent_id' => $request->parent_id,
    //         'body' => $request->body,
    //     ]);

    //     return back();
    // }

        public function store(Request $request)
        {
            $request->validate([
                'body' => 'required|string',
                'post_id' => 'required|exists:posts,id',
                'parent_id' => 'nullable|exists:comments,id', // parent_id can be null or point to a valid comment
            ]);

            Comment::create([
                'user_id' => auth()->id(),
                'post_id' => $request->post_id,
                'parent_id' => $request->parent_id, // if parent_id is null, it's a top-level comment
                'body' => $request->body,
            ]);

            return redirect()->route('posts.show', $request->post_id);
        }
}