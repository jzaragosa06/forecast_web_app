<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    // Specify the table if it's not the plural of the model name
    protected $table = 'notes';

    // Specify which fields are mass assignable
    protected $fillable = ['file_assoc_id', 'content'];

}
