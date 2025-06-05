<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsView extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function news()
    {
        return $this->belongsTo(News::class);
    }
}
