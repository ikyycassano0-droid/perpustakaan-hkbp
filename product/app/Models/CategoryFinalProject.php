<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryFinalProject extends Model
{
    protected $fillable = ['name'];

    public function finalProjects()
    {
        return $this->hasMany(FinalProject::class);
    }
}
