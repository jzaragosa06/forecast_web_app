<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentNotification extends Model
{
    use HasFactory;
    protected $table = "comment_notifications";
    protected $fillable = ["post_id", "post_owner_id", "commenter_user_id"];

}