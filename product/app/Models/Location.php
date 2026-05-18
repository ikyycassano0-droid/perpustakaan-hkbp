<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $table = 'locations';

    protected $fillable = [
        'name',
        'code',
        'description',
        'active'
    ];

    protected $casts = [
        'active' => 'boolean'
    ];

    // ================= RELASI =================
    public function collections()
    {
        return $this->hasMany(Collection::class);
    }

    // ================= ACCESSOR =================
    public function getFullLabelAttribute()
    {
        return $this->code 
            ? $this->name . ' (' . $this->code . ')'
            : $this->name;
    }

    public function getStatusLabelAttribute()
    {
        return $this->active ? 'Aktif' : 'Nonaktif';
    }

    // ================= SCOPES =================
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    // ================= AUTO GENERATE CODE =================
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->code) {
                $model->code = strtoupper(substr($model->name, 0, 3)) . rand(100,999);
            }
        });
    }
}