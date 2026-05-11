<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $primaryKey = 'comment_id';
    protected $fillable = ['article_id', 'user_id', 'message'];

    public function article() {
        return $this->belongsTo(Article::class);
    }
}
