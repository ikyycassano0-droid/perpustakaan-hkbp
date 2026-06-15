<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

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

    /*
    |-------------------------------------------------------
    | RELASI
    |-------------------------------------------------------
    */

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /*
    |-------------------------------------------------------
    | ROLE CHECK
    |-------------------------------------------------------
    */

    public function isAdmin()
    {
        return $this->role?->name === 'Admin';
    }

    public function isMahasiswa()
    {
        return in_array($this->role?->name, ['Mahasiswa', 'Member']);
    }

    public function isDosen()
    {
        return $this->role?->name === 'Dosen';
    }

    /*
    |-------------------------------------------------------
    | PASSWORD HANDLING (AMAN - TANPA DOUBLE HASH)
    |-------------------------------------------------------
    */

    public function setPasswordAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['password'] = Hash::make($value);
        }
    }
}