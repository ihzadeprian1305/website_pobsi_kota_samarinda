<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Athlete extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function standings(){
        return $this->hasOne(Standing::class, 'athlete_id');
    }

    public function athlete_images(){
        return $this->hasOne(AthleteImage::class, 'athlete_id');
    }

    public function pool_houses(){
        return $this->belongsTo(PoolHouse::class, 'pool_house_id');
    }
}
