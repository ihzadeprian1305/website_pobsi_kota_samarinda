<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageGallery extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function image_gallery_images(){
        return $this->hasMany(ImageGalleryImage::class, 'image_gallery_id');
    }
}
