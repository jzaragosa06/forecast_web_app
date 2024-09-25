<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatHistory extends Model
{
    use HasFactory;


    protected $table = 'chat_histories';

    // Specify which fields are mass assignable
    protected $fillable = ['file_assoc_id', 'history'];
}
