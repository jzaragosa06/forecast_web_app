<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicFiles extends Model
{
    use HasFactory;

    protected $table = 'public_files';
    protected $fillable = ['user_id', 'filename', 'filepath', 'type', 'freq', 'description', 'source', 'topics', 'title', 'thumbnail', 'upvote_count'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function upvotes()
    {
        return $this->hasMany(UpvoteFile::class, 'public_file_id');
    }
}