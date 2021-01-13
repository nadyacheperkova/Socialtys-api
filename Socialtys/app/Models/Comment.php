<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
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
        'post_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function userLikes()
    {
        return $this->belongsToMany(User::class);
    }

    public function userReports()
    {
        return $this->hasMany(ReportedComment::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
