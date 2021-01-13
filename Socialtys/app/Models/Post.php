<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'text',
        'user_id',
        'community_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function userLikes()
    {
        return $this->belongsToMany(User::class);
    }

    public function likes()
    {
        return $this->hasMany(PostLikes::class,'post_id');
    }

    public function userReports()
    {
        return $this->hasMany(ReportedPost::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function community()
    {
        return $this->belongsTo(Community::class);
    }
}
