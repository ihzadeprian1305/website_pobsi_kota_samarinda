<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeSliderImage extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function home_sliders(){
        return $this->belongsTo(HomeSlider::class, 'home_slider_id');
    }
}
