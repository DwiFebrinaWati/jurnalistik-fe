<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // Nama tabel di database
    protected $table = 'users';

    // Nama primary key yang kamu pakai
    protected $primaryKey = 'user_id';

    // Kolom yang boleh diisi (Mass Assignment)
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    // Kolom yang disembunyikan saat data dikirim (API)
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relasi ke tabel Roles
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'role_id');
    }

    public function isAdmin(): bool
    {
        return (int)$this->role_id === 1;
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
