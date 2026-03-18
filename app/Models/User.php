<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Kolom yang dapat diisi secara massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role_id',
        'name',
        'npm',
        'nidn',
        'birth_date',
        'gender',
        'phone',
        'photo',
        'password',
        'active',
        'created_by',
        'updated_by',
    ];

    /**
     * Kolom yang harus disembunyikan saat serialisasi (seperti API/JSON).
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting tipe data kolom (Standar Laravel 11).
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'birth_date' => 'date',
            'active' => 'boolean',
            'role_id' => 'integer',
        ];
    }

    /**
     * Helper opsional: Mengecek role user
     * Contoh penggunaan: if($user->isAdmin()) { ... }
     */
    public function isAdmin()
    {
        return $this->role_id === 1;
    }

    public function isDosen()
    {
        return $this->role_id === 2;
    }

    public function isMahasiswa()
    {
        return $this->role_id === 3;
    }
}