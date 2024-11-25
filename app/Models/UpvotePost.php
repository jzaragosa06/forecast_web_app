<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UpvotePost extends Model
{
    use HasFactory;
    protected $table = 'upvote_posts';
    protected $fillable = ['post_id', 'user_id'];

    public function publicFile()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}