<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classification extends Model
{
    protected $fillable = ['name'];

    public function collections()
    {
        return $this->belongsToMany(Collection::class);
    }
}