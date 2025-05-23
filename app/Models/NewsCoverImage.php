<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsCoverImage extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function news(){
        return $this->belongsTo(News::class, 'news_id');
    }
}
