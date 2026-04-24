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

    protected $casts = [
        'author' => 'array',
        'active' => 'boolean',
        'is_available' => 'boolean',
        'stock' => 'integer',
        'available_stock' => 'integer',
    ];

    // RELASI MANY TO MANY
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

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    // ACCESSOR
    public function getAuthorStringAttribute()
    {
        return is_array($this->author)
            ? implode(', ', $this->author)
            : $this->author;
    }
}