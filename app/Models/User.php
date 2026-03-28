<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

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
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    protected $hidden = ['password']; // jangan tampilkan password di query

    protected $casts = [
        'birth_date' => 'date',
        'active' => 'boolean',
    ];

    // Relasi ke role
    public function role() {
        return $this->belongsTo(Role::class, 'role_id');
    }
}