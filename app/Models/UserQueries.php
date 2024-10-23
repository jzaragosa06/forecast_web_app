<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserQueries extends Model
{
    use HasFactory;

    protected $table = 'user_quiries';

    protected $fillable = ['name', 'email', 'message', 'has_responded'];
}