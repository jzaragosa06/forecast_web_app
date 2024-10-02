<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileUserShare extends Model
{
    use HasFactory;

    protected $table = 'file_user_shares';

    protected $fillable = [
        'file_assoc_id',
        'shared_to_user_id',
        'shared_by_user_id'
    ];

    public function fileAssociation()
    {
        return $this->belongsTo(FileAssociation::class, 'file_assoc_id');
    }

    public function sharedToUser()
    {
        return $this->belongsTo(User::class, 'shared_to_user_id');
    }

    public function sharedByUser()
    {
        return $this->belongsTo(User::class, 'shared_by_user_id');
    }
}
