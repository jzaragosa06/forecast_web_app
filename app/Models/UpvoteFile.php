<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UpvoteFile extends Model
{
    use HasFactory;


    protected $table = 'upvote_files';
    protected $fillable = ['public_file_id', 'user_id'];

    public function publicFile()
    {
        return $this->belongsTo(PublicFiles::class, 'public_file_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}