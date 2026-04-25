<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Classification;
use App\Models\CategoryCollection;
use App\Models\Location;
use App\Models\OrderDetail;

class Collection extends Model
{
    use HasFactory;

    protected $table = 'collections';

    // ================= FILLABLE =================
    protected $fillable = [
        'title',
        'series_title',

        'author',
        'responsibility_statement',
        'content_type',
        'media_type',

        'publisher',
        'publication_year',
        'language',
        'isbn',
        'edition',
        'subject',
        'description',

        'carrier_type',
        'specific_detail_info',

        'keywords',

        'location_id',
        'file_url',
        'format',
        'cover_image',

        'created_by',
        'updated_by',

        'active',
        'menu_type',

        'stock',
        'available_stock',
        'is_available',
    ];

    // ================= CAST =================
    protected $casts = [
        'author' => 'array',
        'responsibility_statement' => 'array',
        'content_type' => 'array',
        'media_type' => 'array',
        'keywords' => 'array',

        'active' => 'boolean',
        'is_available' => 'boolean',

        'stock' => 'integer',
        'available_stock' => 'integer',
        'publication_year' => 'integer',
    ];

    // ================= RELASI =================

    // MANY TO MANY
    public function classifications()
    {
        return $this->belongsToMany(
            Classification::class,
            'classification_collection',
            'collection_id',
            'classification_id'
        );
    }

    public function categories()
    {
        return $this->belongsToMany(
            CategoryCollection::class,
            'category_collection_collection',
            'collection_id',
            'category_collection_id'
        );
    }

    // BELONGS TO
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    // OPTIONAL (kalau dipakai)
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    // ================= ACCESSOR =================

    // AUTHOR STRING
    public function getAuthorStringAttribute()
    {
        return is_array($this->author)
            ? implode(', ', $this->author)
            : $this->author;
    }

    // KEYWORDS STRING
    public function getKeywordsStringAttribute()
    {
        return is_array($this->keywords)
            ? implode(', ', $this->keywords)
            : $this->keywords;
    }

    // STATUS STOCK
    public function getStockStatusAttribute()
    {
        if ($this->available_stock <= 0) return 'Habis';
        if ($this->available_stock < 3) return 'Hampir Habis';
        return 'Tersedia';
    }

    // COVER IMAGE URL (AMAN)
    public function getCoverUrlAttribute()
    {
        return $this->cover_image
            ? asset('storage/' . $this->cover_image)
            : 'https://via.placeholder.com/300x400?text=No+Cover';
    }

    // FILE URL (PDF / DLL)
    public function getFileUrlAttribute($value)
    {
        return $value ? asset('storage/' . $value) : null;
    }
}