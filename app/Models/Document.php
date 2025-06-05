<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
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
                    ->where('title', 'like', '%' . $search . '%');
        });

        $query->when($filters['category'] ?? false, function($query, $category){
            return $query->whereHas('document_categories', function($query) use ($category){
                $query->where('id', $category);
            });
        });

        $query->when($filters['author'] ?? false, function($query, $author){
            return $query->whereHas('user_posted_by', function($query) use ($author){
                $query->where('id', $author);
            });
        });
    }

    public function document_cover_images(){
        return $this->hasOne(DocumentCoverImage::class, 'document_id');
    }

    public function document_categories(){
        return $this->belongsTo(DocumentCategory::class, 'document_category_id');
    }

    public function document_files(){
        return $this->hasMany(DocumentFile::class, 'document_id');
    }

    public function user_posted_by(){
        return $this->belongsTo(User::class, 'posted_by');
    }

    public function document_views(){
        return $this->hasMany(DocumentView::class);
    }

    public function document_views_today(){
        return $this->hasMany(DocumentView::class)->whereDate('viewed_at', today());
    }
}
