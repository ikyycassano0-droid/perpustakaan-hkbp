<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
    protected $fillable = [
        'title',
        'description',
        'category',
        'active'
    ];

    public function files()
    {
        return $this->hasMany(ArchiveFile::class);
    }
}
