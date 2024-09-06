<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileAssociation extends Model
{
    use HasFactory;

    protected $fillable = ['file_id', 'user_id', 'assoc_filename', 'associated_file_path', 'operation'];
    public function file()
    {
        return $this->belongsTo(File::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
