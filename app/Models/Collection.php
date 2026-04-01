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
        'classification_id',
        'category_collection_id',
        'location_id',
        'file_url',
        'format',
        'cover_image',
        'created_by',
        'updated_by',
        'active',
    ];

    protected $casts = [
        'author' => 'array',
        'responsibility_statement' => 'array',
        'content_type' => 'array',
        'media_type' => 'array',
        'active' => 'boolean',
    ];

    public function classifications()
    {
        return $this->belongsToMany(Classification::class);
    }

    public function category()
    {
        return $this->belongsTo(CategoryCollection::class, 'category_collection_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function getAuthorStringAttribute()
    {
        return $this->author ? implode(', ', $this->author) : '-';
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

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}