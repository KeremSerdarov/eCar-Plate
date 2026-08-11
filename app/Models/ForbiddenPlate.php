<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForbiddenPlate extends Model
{
    public $timestamps = false;

    protected $fillable = ['number', 'reason'];
}