<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArchiveFile extends Model
{
    protected $fillable = [
        'file_url',
        'archive_id',
        'active'
    ];

    public function archive()
    {
        return $this->belongsTo(Archive::class);
    }
}
