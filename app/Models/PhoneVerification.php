<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhoneVerification extends Model
{
    protected $fillable = [
        'phone_number',
        'code',
        'is_verified',
        'expires_at',
    ];
}