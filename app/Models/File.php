<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'filename', 'filepath', 'type', 'freq', 'description'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function associations()
    {
        return $this->hasMany(FileAssociation::class);
    }
}
