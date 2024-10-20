<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;
    protected $table = 'course_content';
    protected $fillable = [
        'course_id',
        'file_name',
        'professor_id'
    ];
}
