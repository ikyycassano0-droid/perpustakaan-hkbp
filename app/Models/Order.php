<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'order_date',
        'return_date',
        'actual_return_date',
        'fine',
        'extension_count',
        'status'
    ];

    protected $casts = [
    'order_date' => 'datetime',
    'return_date' => 'datetime',
    'actual_return_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }
}