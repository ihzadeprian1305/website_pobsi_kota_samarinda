<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory, Sluggable;

    protected $guarded = [
        'id',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function scopeFilter($query, $filters)
    {
        $query->when($filters['search'] ?? false, function($query, $search){
            return $query
                    ->where('title', 'like', '%' . $search . '%')
                    ->orWhere('content', 'like', '%' . $search . '%');
        });

        $query->when($filters['category'] ?? false, function($query, $category){
            return $query->whereHas('news_categories', function($query) use ($category){
                $query->where('id', $category);
            });
        });

        $query->when($filters['tag'] ?? false, function($query, $tag){
            return $query->whereHas('news_tags', function($query) use ($tag){
                $query->where('news_tag_id', $tag);
            });
        });

        $query->when($filters['author'] ?? false, function($query, $author){
            return $query->whereHas('user_created_by', function($query) use ($author){
                $query->where('id', $author);
            });
        });
    }

    public function news_categories(){
        return $this->belongsTo(NewsCategory::class, 'news_category_id');
    }

    public function news_tags(){
        return $this->belongsToMany(NewsTag::class, 'news_news_tags', 'news_id', 'news_tag_id');
    }

    public function user_created_by(){
        return $this->belongsTo(User::class, 'created_by');
    }

    public function user_posted_by(){
        return $this->belongsTo(User::class, 'posted_by');
    }

    public function news_cover_images(){
        return $this->hasOne(NewsCoverImage::class, 'news_id');
    }

    public function news_images(){
        return $this->hasMany(NewsImage::class, 'news_id');
    }

    public function news_views(){
        return $this->hasMany(NewsView::class);
    }

    public function news_views_today(){
        return $this->hasMany(NewsView::class)->whereDate('viewed_at', today());
    }
}
