<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoGalleryVideo extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function video_galleries(){
        return $this->belongsTo(VideoGallery::class, 'video_gallerie_id');
    }
}
