<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function comment()
    {
        return $this->morphMany('App\Models\Comment', 'commentable');
    }

    public function tag()
    {
        return $this->morphToMany('App\Models\Tag', 'taggable');
    }
}
