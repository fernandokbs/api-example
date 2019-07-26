<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'author_id', 'content'];

    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }

    public function author()
    {
        return $this->belongsTo('App\User','author_id');
    }

    public function isAuthorLoaded()
    {
        return $this->relationLoaded('author');
    }

    public function isCommentsLoaded()
    {
        return $this->relationLoaded('comments');
    }
}
