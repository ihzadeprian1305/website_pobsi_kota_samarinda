<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AthleteImage extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function athletes(){
        return $this->belongsTo(Athlete::class, 'athlete_id');
    }
}
