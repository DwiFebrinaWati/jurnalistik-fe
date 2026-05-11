<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    protected $fillable = ['fileType', 'title', 'url', 'cover_by', 'cover_image'];
    protected $primaryKey = 'work_id';
}
