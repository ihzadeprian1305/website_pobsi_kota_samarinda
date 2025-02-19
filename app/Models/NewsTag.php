<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsTag extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function scopeFilter($query, $filters)
    {
        $query->when($filters['search'] ?? false, function($query, $search){
            return $query
                    ->where('name', 'like', '%' . $search . '%');
        });
    }

    public function news(){
        return $this->belongsToMany(News::class, 'news_news_tags', 'news_tag_id', 'news_id');
    }
}
