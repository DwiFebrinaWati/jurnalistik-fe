<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $primaryKey = 'material_id';
    protected $fillable = ['title', 'description', 'googleDriveLink'];
}
