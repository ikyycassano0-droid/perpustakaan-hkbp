<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryCollection extends Model
{
    use HasFactory;

    protected $table = 'category_collections';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'active'
    ];

    protected $casts = [
        'active' => 'boolean'
    ];

    // ================= RELASI =================
    public function collections()
    {
        return $this->belongsToMany(
            Collection::class,
            'category_collection_collection'
        )->withTimestamps();
    }

    // ================= ACCESSOR =================
    public function getStatusLabelAttribute()
    {
        return $this->active ? 'Aktif' : 'Nonaktif';
    }

    // ================= SCOPES =================
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    // ================= BOOT AUTO SLUG =================
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->slug = \Str::slug($model->name);
        });

        static::updating(function ($model) {
            $model->slug = \Str::slug($model->name);
        });
    }
}