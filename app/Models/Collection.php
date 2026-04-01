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
        'call_number',
        'publisher',
        'publication_year',
        'language',
        'isbn',
        'classification_id',
        'edition',
        'subject',
        'description',
        'category_collection_id',
        'location_id',
        'file_url',
        'format',
        'cover_image',
        'responsibility_statement',
        'content_type',
        'media_type',
        'carrier_type',
        'specific_detail_info',
        'created_by',
        'updated_by',
        'active',
    ];

    protected $casts = [
        'publication_year' => 'integer',
        'active' => 'boolean',
    ];


    public function category()
    {
        return $this->belongsTo(CategoryCollection::class, 'category_collection_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    // Classification
    public function classification()
    {
        return $this->belongsTo(Classification::class, 'classification_id');
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeSearch($query, $keyword)
    {
        return $query->where('title', 'like', "%$keyword%")
            ->orWhere('author', 'like', "%$keyword%")
            ->orWhere('isbn', 'like', "%$keyword%");
    }

    public function getCoverUrlAttribute()
    {
        return $this->cover_image
            ? asset('storage/' . $this->cover_image)
            : 'https://via.placeholder.com/200x300';
    }

    public function getFileUrlAttribute($value)
    {
        return $value ? asset('storage/' . $value) : null;
    }
}