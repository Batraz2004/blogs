<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class News extends Model
{
    protected $guarded = [];

    protected static function booted()
    {
        static::deleting(function ($news) {
            $news->comments()->each(function ($comment) {
                $comment->delete();
            });
        });
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
