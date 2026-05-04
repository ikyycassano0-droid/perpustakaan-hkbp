<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
    'user_id',
    'order_date',
    'borrow_date',
    'due_date',
    'return_date',
    'actual_return_date',
    'fine',
    'extension_count',
    'is_extended',
    'extended_until',
    'status'
    ];

    protected $casts = [
        'order_date' => 'datetime',
        'borrow_date' => 'datetime',
        'due_date' => 'datetime',
        'actual_return_date' => 'datetime',
        'extended_until' => 'datetime',
        'is_extended' => 'boolean',
    ];

    // ================= RELATION =================

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }

    // 🔥 OPTIONAL (Biar enak di blade)
    public function getIsLateAttribute()
    {
        return $this->due_date && now()->gt($this->due_date);
    }

    public function getRemainingDaysAttribute()
    {
        if (!$this->due_date) return 0;

        return now()->diffInDays($this->due_date, false);
    }

    public function scopeActiveBorrow($query)
    {
        return $query->whereIn('status', ['PENDING', 'APPROVED'])
            ->whereNull('actual_return_date');
    }

    public static function canBorrow($userId, $collectionId)
    {
        return !self::where('user_id', $userId)
            ->activeBorrow()
            ->whereHas('details', function ($q) use ($collectionId) {
                $q->where('collection_id', $collectionId);
            })
            ->exists();
    }
}