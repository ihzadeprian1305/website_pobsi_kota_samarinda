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
        return $this->belongsTo(VideoGallery::class, 'video_gallery_id');
    }

    public function video_gallery_video_images(){
        return $this->hasMany(VideoGalleryVideoImage::class, 'video_gallery_video_id');
    }
}
