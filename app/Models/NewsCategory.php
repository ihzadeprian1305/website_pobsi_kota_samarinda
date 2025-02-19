<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsCategory extends Model
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
        return $this->hasMany(News::class, 'news_category_id');
    }
}
