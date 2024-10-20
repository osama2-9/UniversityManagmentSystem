<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Student extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $table = 'students';
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'gender',
        'college',
        'date_of_birth',
        'studant_address',
    ];
}
