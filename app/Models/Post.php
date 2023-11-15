<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

    private $directory = "/images/";

    protected $fillable = [
        'title',
        'content',
        'user_id',
        'path'
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

    public function getPathAttribute($value) 
    {
        return $this->directory . $value;
    }

    // public static function scopeLatest($query)
    // {
    //     return $query->orderBy('id', 'asc');    // 강의대로 작동하지 않음... 공부 필요
    // }

}
