<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StructurePosition extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function structures(){
        return $this->hasMany(Structure::class, 'structure_position_id');
    }

    public function structure_fields(){
        return $this->belongsTo(StructureField::class, 'structure_field_id');
    }
}
