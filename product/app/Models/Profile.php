<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $table = 'profiles';

    protected $fillable = [
        'type',
        'sub_type',
        'title',
        'description',
        'image',
        'jabatan',
        'icon',
        'order',
        'active',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'active' => 'boolean'
    ];

    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return null;
    }

    protected static function boot()
    {
        parent::boot();

        // Hanya validasi untuk visi (satu record aktif)
        static::creating(function ($model) {
            if ($model->type == 'visi_misi' && $model->sub_type == 'visi') {
                $exists = static::where('type', $model->type)
                    ->where('sub_type', $model->sub_type)
                    ->where('active', true)
                    ->exists();

                if ($exists) {
                    throw new \Exception('Visi sudah ada, tidak bisa membuat baru.');
                }
            }
        });
    }
}