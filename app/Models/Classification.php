<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Collection;

class Classification extends Model
{
    protected $table = 'classifications';

    protected $fillable = [
        'name',
        'code',
        'description',
        'active',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    // ================= RELATION =================

    public function collections()
    {
        return $this->belongsToMany(
            Collection::class,
            'classification_collection', // pivot table (pastikan ini sesuai DB)
            'classification_id',
            'collection_id'
        );
    }

    // ================= SCOPE =================

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    // ================= ACCESSOR =================

    public function getStatusLabelAttribute()
    {
        return $this->active ? 'Aktif' : 'Nonaktif';
    }
}