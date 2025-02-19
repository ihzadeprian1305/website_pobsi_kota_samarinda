<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Handicap extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function standings(){
        return $this->hasMany(Standing::class, 'handicap_id');
    }
}
