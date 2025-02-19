<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Standing extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function athletes(){
        return $this->belongsTo(Athlete::class, 'athlete_id');
    }

    public function handicaps(){
        return $this->belongsTo(Handicap::class, 'handicap_id');
    }
}
