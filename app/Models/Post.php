<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $table = 'posts';
    protected $fillable = ['user_id', 'file_assoc_id', 'title', 'body'];

    // A post belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // A post has many comments
    public function comments()
    {
        return $this->hasMany(Comment::class)->whereNull('parent_id');
    }
}