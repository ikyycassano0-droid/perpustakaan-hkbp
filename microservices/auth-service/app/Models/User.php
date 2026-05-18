<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'role_id',
        'name',
        'email',
        'npm',
        'nidn',
        'birth_date',
        'gender',
        'membership_type',
        'phone',
        'photo',
        'password',
        'active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'active' => 'boolean',
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function isAdmin(): bool
    {
        return $this->role?->name === 'Admin';
    }

    public function isMahasiswa(): bool
    {
        return in_array($this->role?->name, ['Mahasiswa', 'Member']);
    }

    public function isDosen(): bool
    {
        return $this->role?->name === 'Dosen';
    }

    public function setPasswordAttribute($value): void
    {
        if (!empty($value)) {
            if (Hash::needsRehash($value)) {
                $this->attributes['password'] = Hash::make($value);
            } else {
                $this->attributes['password'] = $value;
            }
        }
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}