<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoolHouse extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function pool_house_images(){
        return $this->hasMany(PoolHouseImage::class, 'pool_house_id');
    }
}
