<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;
    
    protected $fillable = [
        'name', 'username', 'email', 'password', 'avatar'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'followed_id', 'follower_id');
    }

    public function following()
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'followed_id');
    }

    public function setAvatarAttribute($value)
    {
        if (is_file($value)) {
            $this->attributes['avatar'] = Storage::disk('public')->put('avatars', $value);
        } else {
            $this->attributes['avatar'] = $value;
        }
    }

    public function getAvatarUrlAttribute()
    {
        return $this->avatar ? Storage::url($this->avatar) : null;
    }

    public function follow(User $user)
    {
        return $this->following()->attach($user->id);
    }

    public function unfollow(User $user)
    {
        return $this->following()->detach($user->id);
    }

    public function isFollowing(User $user)
    {
        return $this->following->contains($user->id);
    }

    public function isFollowedBy(User $user)
    {
        return $this->followers->contains($user->id);
    }

    protected static function booted()
    {
        static::deleting(function ($user) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
        });
    }
}
?>