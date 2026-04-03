<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classification extends Model
{
    protected $fillable = ['name', 'code'];

    public function collections()
    {
        return $this->belongsToMany(Collection::class);
    }
}