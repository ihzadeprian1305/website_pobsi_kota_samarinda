<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentCategory extends Model
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

    public function documents(){
        return $this->hasOne(Document::class, 'document_category_id');
    }
}
