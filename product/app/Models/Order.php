<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Order extends Model
{
    // ================= KONSTANTA =================
    const MAX_BORROW_DAYS = 3;      // Maksimal durasi pinjam 3 hari
    const MAX_BORROW_COUNT = 3;     // Maksimal 3 buku aktif
    const MAX_EXTEND_COUNT = 3;     // Maksimal perpanjangan 3 kali
    const EXTEND_DAYS = 3;          // Setiap perpanjangan 3 hari

    protected $fillable = [
        'user_id',
        'order_date',
        'borrow_date',
        'due_date',
        'actual_return_date',
        'fine',
        'is_extended',
        'extended_until',
        'extend_days',
        'original_due_date',
        'status'
    ];

    protected $casts = [
        'order_date' => 'date',
        'borrow_date' => 'date',
        'due_date' => 'date',
        'actual_return_date' => 'date',
        'extended_until' => 'date',
        'original_due_date' => 'date',
        'extend_days' => 'integer',
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

    // ================= ACCESSORS =================

    // Mengecek apakah peminjaman terlambat
    public function getIsLateAttribute()
    {
        return $this->due_date && Carbon::now()->gt($this->due_date);
    }

    // Menghitung sisa hari sebelum jatuh tempo
    public function getRemainingDaysAttribute()
    {
        if (!$this->due_date) return 0;
        $diff = Carbon::now()->diffInDays($this->due_date, false);
        return $diff < 0 ? 0 : $diff;
    }

    // Mendapatkan jumlah hari keterlambatan
    public function getLateDaysAttribute()
    {
        if (!$this->due_date) return 0;
        $lateDays = Carbon::now()->diffInDays($this->due_date, false);
        return $lateDays < 0 ? 0 : $lateDays;
    }

    // Mendapatkan jumlah perpanjangan yang sudah dilakukan
    public function getExtendCountAttribute()
    {
        return (int)($this->extend_days / self::EXTEND_DAYS);
    }

    // Mendapatkan sisa kuota perpanjangan
    public function getRemainingExtendCountAttribute()
    {
        $used = $this->extend_count;
        $remaining = self::MAX_EXTEND_COUNT - $used;
        return $remaining < 0 ? 0 : $remaining;
    }

    // ================= STATIC METHODS =================

    // Cek apakah user masih bisa meminjam (belum mencapai 3 buku aktif)
    public static function canBorrowMore($userId)
    {
        $activeBorrows = self::where('user_id', $userId)
            ->activeBorrow()
            ->count();

        return $activeBorrows < self::MAX_BORROW_COUNT;
    }

    // Cek apakah user sudah meminjam buku tertentu (untuk cek duplikat)
    public static function hasActiveBorrow($userId, $collectionId)
    {
        return self::where('user_id', $userId)
            ->activeBorrow()
            ->whereHas('details', function ($q) use ($collectionId) {
                $q->where('collection_id', $collectionId);
            })
            ->exists();
    }

    // Hitung total buku aktif yang dipinjam user
    public static function countActiveBorrows($userId)
    {
        return self::where('user_id', $userId)
            ->activeBorrow()
            ->count();
    }

    // ================= SCOPES =================

    // Scope untuk peminjaman yang masih aktif (belum dikembalikan)
    public function scopeActiveBorrow($query)
    {
        return $query->whereIn('status', ['PENDING', 'APPROVED'])
            ->whereNull('actual_return_date');
    }

    // Scope untuk peminjaman yang sudah disetujui
    public function scopeApproved($query)
    {
        return $query->where('status', 'APPROVED');
    }

    // Scope untuk peminjaman yang pending
    public function scopePending($query)
    {
        return $query->where('status', 'PENDING');
    }

    // ================= INSTANCE METHODS =================

    // Cek apakah order bisa diperpanjang
    public function canExtend()
    {
        // Maksimal perpanjangan 3 kali
        if ($this->extend_count >= self::MAX_EXTEND_COUNT) {
            return false;
        }

        // Status harus APPROVED
        if ($this->status !== 'APPROVED') {
            return false;
        }

        // Belum dikembalikan
        if ($this->actual_return_date) {
            return false;
        }

        // Belum lewat due date (masih bisa perpanjang sebelum jatuh tempo)
        if (Carbon::now()->gt($this->due_date)) {
            return false;
        }

        return true;
    }

    // Cek apakah order sudah melewati jatuh tempo
    public function isOverdue()
    {
        return $this->due_date && Carbon::now()->gt($this->due_date);
    }

    // Hitung denda berdasarkan tanggal pengembalian
    public function calculateFine($returnDate = null)
    {
        $return = $returnDate ? Carbon::parse($returnDate) : Carbon::now();
        $lateDays = Carbon::parse($this->due_date)->diffInDays($return, false);

        if ($lateDays <= 0) return 0;

        $fine = 0;
        for ($i = 1; $i <= $lateDays; $i++) {
            $fine += ($i <= 3) ? 2000 : 5000;
        }
        return $fine;
    }

    // Perpanjang peminjaman
    public function doExtend($days = null)
    {
        $extendDays = $days ?? self::EXTEND_DAYS;

        if (!$this->canExtend()) {
            return false;
        }

        $oldDueDate = Carbon::parse($this->due_date);
        $newDueDate = $oldDueDate->copy()->addDays($extendDays);

        // Simpan original due date jika pertama kali perpanjang
        if ($this->extend_days == 0) {
            $this->original_due_date = $this->due_date;
        }

        $this->update([
            'due_date'       => $newDueDate,
            'is_extended'    => 1,
            'extended_until' => $newDueDate,
            'extend_days'    => $this->extend_days + $extendDays,
        ]);

        return true;
    }

    // Kembalikan buku
    public function doReturn($returnDate = null)
    {
        $return = $returnDate ? Carbon::parse($returnDate) : Carbon::now();
        $fine = $this->calculateFine($return);

        $this->update([
            'actual_return_date' => $return,
            'fine' => $fine,
            'status' => 'RETURNED'
        ]);

        // Update stok buku
        foreach ($this->details as $detail) {
            $detail->collection->increment('available_stock', $detail->qty);
        }

        return $fine;
    }

    // Approve peminjaman
    public function approve()
    {
        // Kurangi stok untuk setiap detail
        foreach ($this->details as $detail) {
            if ($detail->collection->available_stock < $detail->qty) {
                throw new \Exception('Stok tidak cukup');
            }
        }

        foreach ($this->details as $detail) {
            $detail->collection->decrement('available_stock', $detail->qty);
        }

        $this->update(['status' => 'APPROVED']);

        return true;
    }

    // Reject peminjaman
    public function reject()
    {
        $this->update(['status' => 'REJECTED']);
        return true;
    }
}
