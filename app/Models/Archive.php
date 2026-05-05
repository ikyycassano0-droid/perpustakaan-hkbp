<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ArchiveFile;
use App\Models\User;

class Archive extends Model
{
    protected $table = 'archives';

    protected $fillable = [
        'title',
        'description',
        'category',
        'icon',
        'sequence',
        'active',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'active' => 'boolean',
        'sequence' => 'integer',
    ];

    public function files()
    {
        return $this->hasMany(ArchiveFile::class);
    }

    public function activeFiles()
    {
        return $this->hasMany(ArchiveFile::class)
                    ->where('active', 1)
                    ->orderBy('created_at', 'desc');
    }

    public function firstFile()
    {
        return $this->hasOne(ArchiveFile::class)
                    ->where('active', 1)
                    ->latestOfMany();
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function getFirstFileAttribute()
    {
        return $this->activeFiles()->first();
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sequence');
    }
}