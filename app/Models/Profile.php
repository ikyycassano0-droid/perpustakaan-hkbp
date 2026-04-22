<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'type',
        'sub_type',
        'title',
        'description',
        'jabatan',
        'icon',
        'image',
        'order',
    ];
}