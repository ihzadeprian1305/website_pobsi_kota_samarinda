<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Structure extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function structure_images(){
        return $this->hasOne(StructureImage::class, 'structure_id');
    }

    public function structure_positions(){
        return $this->belongsTo(StructurePosition::class, 'structure_position_id');
    }
}
