<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    protected $primaryKey = 'article_id';
    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'content',
        'photo',
        'status',
        'publish_date'
    ];

    protected function casts(): array
    {
        return [
            'publish_date' => 'datetime',
        ];
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($article) {
            $article->slug = Str::slug($article->title) . '-' . Str::random(5);

        });
    }
}
