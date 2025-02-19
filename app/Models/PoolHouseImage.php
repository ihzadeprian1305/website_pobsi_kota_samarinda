<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoolHouseImage extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function pool_houses(){
        return $this->belongsTo(PoolHouse::class, 'pool_house_id');
    }
}
