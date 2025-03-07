<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoGalleryVideoImage extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function video_gallery_videos(){
        return $this->belongsTo(VideoGalleryVideo::class, 'video_gallery_video_id');
    }
}
