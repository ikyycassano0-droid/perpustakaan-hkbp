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
        'excerpt',
        'content',
        'image',
        'category',
        'is_featured',
        'button_text',
        'button_action',
        'order',
        'status',
        'active',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'active'      => 'boolean',
    ];

    // ================= SCOPE UTAMA =================

    /**
     * hanya berita yang tampil di publik
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'publish')
                     ->where('active', true);
    }

    /**
     * filter kategori (aman + fleksibel)
     */
    public function scopeOfCategory($query, $category = null)
    {
        if ($category && $category !== 'all') {
            return $query->where('category', $category);
        }

        return $query;
    }

    /**
     * featured news
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * urutan tampilan
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc')
                     ->orderBy('created_at', 'desc');
    }

    /**
     * search (judul + ringkasan + isi)
     */
    public function scopeSearch($query, $keyword)
    {
        return $query->where(function ($q) use ($keyword) {
            $q->where('title', 'like', "%{$keyword}%")
              ->orWhere('excerpt', 'like', "%{$keyword}%")
              ->orWhere('content', 'like', "%{$keyword}%");
        });
    }
}