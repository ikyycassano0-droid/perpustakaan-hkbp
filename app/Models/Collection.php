<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;

    protected $table = 'collections';
    protected $fillable = [
        'title',
        'series_title',
        'author',
        'publisher',
        'publication_year',
        'language',
        'isbn',
        'edition',
        'subject',
        'description',
        'responsibility_statement',
        'content_type',
        'media_type',
        'carrier_type',
        'specific_detail_info',
        'location_id',
        'file_url',
        'format',
        'cover_image',
        'created_by',
        'updated_by',
        'active',
        'menu_type',
        'stock',
    ];

    protected $casts = [
        'author' => 'array',
        'responsibility_statement' => 'array',
        'content_type' => 'array',
        'media_type' => 'array',
        'active' => 'boolean',
        'stock' => 'integer',
        'is_restricted' => 'boolean',
    ];

    // ================= RELASI MANY TO MANY =================
    public function classifications()
    {
        return $this->belongsToMany(Classification::class, 'classification_collection');
    }

    public function categories()
    {
        return $this->belongsToMany(CategoryCollection::class, 'category_collection_collection');
    }

    // ================= RELASI LAIN =================
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    // ================= ACCESSORS =================
    public function getAuthorStringAttribute()
    {
        return $this->author ? implode(', ', $this->author) : '-';
    }

    public function getAuthorsArrayAttribute()
    {
        return $this->author ?? [];
    }

    public function getContentTypeStringAttribute()
    {
        return $this->content_type ? implode(', ', $this->content_type) : '-';
    }

    public function getMediaTypeStringAttribute()
    {
        return $this->media_type ? implode(', ', $this->media_type) : '-';
    }

    public function getResponsibilityStringAttribute()
    {
        return $this->responsibility_statement
            ? implode(', ', $this->responsibility_statement)
            : '-';
    }

    public function getClassificationIdsAttribute()
    {
        return $this->classifications ? $this->classifications->pluck('id')->toArray() : [];
    }

    public function getCategoryIdsAttribute()
    {
        return $this->categories ? $this->categories->pluck('id')->toArray() : [];
    }

    // ================= HELPER =================
    public function isAudio()
    {
        if (!$this->file_url) return false;

        $ext = pathinfo($this->file_url, PATHINFO_EXTENSION);
        return in_array(strtolower($ext), ['mp3', 'wav', 'ogg']);
    }

    public function isPdf()
    {
        if (!$this->file_url) return false;

        $ext = pathinfo($this->file_url, PATHINFO_EXTENSION);
        return strtolower($ext) === 'pdf';
    }

    // ================= SCOPES =================
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
