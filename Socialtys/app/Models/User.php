<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstName',
        'lastName',
        'occupationField',
        'email',
        'type',
        'skills',
        'interests',
        'first_login',
        'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'skills' => 'array',
        'interests' => 'array'
    ];

    public function communities()
    {
        return $this->belongsToMany(Community::class, );
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function jobs()
    {
        return $this->hasMany(Post::class);
    }

    public function postLikes()
    {
        return $this->belongsToMany(Post::class);
    }

    public function reportedPosts()
    {
        return $this->hasMany(RepostedPost::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function commentLikes()
    {
        return $this->belongsToMany(Comment::class);
    }

    public function reportedComments()
    {
        return $this->hasMany(ReportedComment::class);
    }

    public function chatMessages()
    {
        return $this->hasMany(ChatMessage::class);
    }


    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
}
