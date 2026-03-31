<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $table = 'news';

    protected $fillable = [
        'title',
        'content',
        'image',
        'status',       
        'created_by',
        'updated_by',
    ];

    /**
     * Scope: hanya berita publish
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'publish');
    }

    /**
     * Scope: hanya draft
     */
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }
}