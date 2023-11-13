<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function image()
    {
        return $this->morphOne('App\Models\Image', 'imageable');
    }

    public function comment()
    {
        return $this->morphMany('App\Models\Comment', 'commentable');
    }

    public function tag()
    {
        return $this->morphToMany('App\Models\Tag', 'taggable');
    }
}
