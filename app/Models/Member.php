<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = ['fullName', 'phoneNumber', 'photo', 'status'];
    protected $primaryKey = 'members_id';
}
