<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Auth;

class CommentController extends Controller
{


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
        session()->flash('comment_success', 'Comment added successfully!');
        return redirect()->route('posts.show', $request->post_id);
    }
}