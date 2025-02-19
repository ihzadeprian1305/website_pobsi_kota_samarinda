<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageGalleryImage extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function image_galleries(){
        return $this->belongsTo(ImageGallery::class, 'image_gallerie_id');
    }
}
