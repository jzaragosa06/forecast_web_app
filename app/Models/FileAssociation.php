<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileAssociation extends Model
{
    use HasFactory;
    protected $primaryKey = 'file_assoc_id';
    protected $fillable = ['file_assoc_id', 'file_id', 'user_id', 'assoc_filename', 'associated_file_path', 'operation', 'description'];
    public function file()
    {
        return $this->belongsTo(File::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function sharedWithUsers()
    {
        // Users this file is shared with
        return $this->belongsToMany(User::class, 'file_user_shares', 'file_assoc_id', 'shared_to_user_id')
            ->withTimestamps();
    }

}