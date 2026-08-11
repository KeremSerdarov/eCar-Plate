<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = [
        'full_name',
        'date_of_birth',
        'passport_number',
        'phone_number',
    ];
}