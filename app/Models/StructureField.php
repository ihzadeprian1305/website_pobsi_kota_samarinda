<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StructureField extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function structures(){
        return $this->hasMany(Structure::class, 'structure_field_id');
    }
}
