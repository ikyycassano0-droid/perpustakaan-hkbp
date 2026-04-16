<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Role;

class User extends Authenticatable
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'role_id',
        'name',
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

    protected $hidden = ['password'];

    protected $casts = [
        'birth_date' => 'date',
        'active' => 'boolean',
    ];

    // ================= RELASI =================
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    // ================= HELPER (🔥 PENTING) =================
    public function isAdmin()
    {
        return $this->role?->name === 'Admin';
    }

    public function isMahasiswa()
    {
        return $this->role?->name === 'Mahasiswa' || $this->role?->name === 'Member';
    }

    public function isDosen()
    {
        return $this->role?->name === 'Dosen';
    }
}