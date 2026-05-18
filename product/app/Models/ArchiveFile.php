<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Archive;

class ArchiveFile extends Model
{
    protected $table = 'archive_files';

    protected $fillable = [
        'archive_id',
        'file_name',
        'file_url',
        'file_type',
        'file_size',
        'published_at',
        'active',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'active' => 'boolean',
        'file_size' => 'integer',
        'published_at' => 'date',
    ];

    public function archive()
    {
        return $this->belongsTo(Archive::class);
    }

    public function getSizeLabelAttribute()
    {
        if (!$this->file_size) return '-';

        if ($this->file_size >= 1024) {
            return round($this->file_size / 1024, 1) . ' MB';
        }

        return $this->file_size . ' KB';
    }

    public function getFormattedDateAttribute()
    {
        return $this->published_at
            ? $this->published_at->translatedFormat('d F Y')
            : '-';
    }

    public function getFileUrlFullAttribute()
    {
        return asset('storage/' . $this->file_url);
    }
}