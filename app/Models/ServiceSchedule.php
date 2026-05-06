<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceSchedule extends Model
{
    protected $table = 'service_schedules';

    protected $fillable = [
        'day_short',
        'day_name',
        'service_hours',
        'status',
        'status_color',
        'note',
        'order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Default sorting (biar tidak lupa orderBy di controller)
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}