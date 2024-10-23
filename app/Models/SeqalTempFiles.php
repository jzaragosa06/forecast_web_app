<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeqalTempFiles extends Model
{
    use HasFactory;

    protected $table = 'seqal_temp_files';

    // Specify which fields are mass assignable
    protected $fillable = ['file_id', 'user_id', 'type', 'freq', 'filename', 'description', 'filepath', 'source'];
}