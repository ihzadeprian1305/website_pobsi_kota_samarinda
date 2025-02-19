<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];

    protected $guarded = [
        'id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function user_data(){
        return $this->hasOne(UserDatum::class, 'user_id');
    }

    public function user_images(){
        return $this->hasOne(UserImage::class, 'user_id');
    }

    public function user_levels(){
        return $this->belongsTo(UserLevel::class, 'user_level_id');
    }

    public function news_created_by(){
        return $this->hasMany(News::class, 'created_by');
    }

    public function news_posted_by(){
        return $this->hasMany(News::class, 'posted_by');
    }

    public function document_posted_by(){
        return $this->hasMany(News::class, 'posted_by');
    }
}
