<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plate extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'number',
        'prefix',
        'region_id',
        'plate_type_id',
        'user_id',
        'car_model',
        'price_paid',
        'registered_at',
    ];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function plateType()
    {
        return $this->belongsTo(PlateType::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}