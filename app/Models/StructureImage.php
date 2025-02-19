<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StructureImage extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function structures(){
        return $this->belongsTo(Structure::class, 'structure_id');
    }
}
