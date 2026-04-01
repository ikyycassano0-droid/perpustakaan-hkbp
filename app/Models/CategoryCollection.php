<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryCollection extends Model
{
    use HasFactory;

    protected $table = 'category_collections';

    protected $fillable = [
        'name'
    ];

    // ================= RELASI MANY TO MANY =================
    public function collections()
    {
        return $this->belongsToMany(Collection::class, 'category_collection_collection');
    }
}