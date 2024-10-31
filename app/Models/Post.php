<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'image', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return date('d-m-Y H:i', strtotime($value));
    }

    public function getUpdatedAtAttribute($value)
    {
        return date('d-m-Y H:i', strtotime($value));
    }

    public function setImageAttribute($value)
    {
        if (is_file($value)) {
            $this->attributes['image'] = Storage::disk('public')->put('images', $value);
        } else {
            $this->attributes['image'] = $value;
        }
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? Storage::url($this->image) : null;
    }

    protected static function booted()
    {
        static::deleting(function ($post) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
        });
    }
}
?>