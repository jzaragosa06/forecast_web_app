<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\CommentNotification;
use App\Models\Post;
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

        #create a notification entry
        #resolve the owner of the post.
        $post_owner = Post::where("id", $request->post_id)->first();
        $post_owner_id = $post_owner->user_id;

        CommentNotification::create([
            "post_id" => $request->post_id,
            "post_owner_id" => $post_owner_id,
            "commenter_user_id" => Auth::id(),
        ]);
        session()->flash('success', 'Comment added successfully!');
        return redirect()->route('posts.show', $request->post_id);
    }
}