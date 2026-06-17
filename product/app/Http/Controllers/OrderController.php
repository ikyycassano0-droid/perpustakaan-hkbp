<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Collection;
use App\Models\Location;
use Carbon\Carbon;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class OrderController extends Controller
{
    // ================= KONSTANTA =================
    const MAX_BORROW_DAYS = 3;        // Maksimal durasi pinjam 3 hari (hanya untuk mahasiswa)
    const MAX_BORROW_COUNT = 3;       // Maksimal 3 buku aktif (hanya untuk mahasiswa)
    const MAX_EXTEND_COUNT = 3;       // Maksimal perpanjangan 3 kali (hanya untuk mahasiswa)
    const EXTEND_DAYS = 3;            // Setiap perpanjangan 3 hari

    // ================= ADMIN =================
    public function index()
    {
        $orders = Order::with(['user', 'details.collection.location'])
            ->latest()
            ->get();

        $collections = Collection::with('location')->get();
        $locations = Location::all();

        return view('admin.page.pengelolaan_buku', compact(
            'orders',
            'collections',
            'locations'
        ));
    }

    // ================= USER PINJAM =================
    public function store(Request $request)
    {
        Log::info('=== ORDER STORE START ===');
        Log::info('Request data:', $request->all());

        $collectionId = $request->input('collection_id');
        $borrowDate = $request->input('borrow_date');
        $returnDate = $request->input('return_date');

        // Validasi collection
        $collection = Collection::find($collectionId);
        if (!$collection) {
            return redirect()->back()->with('error', 'Buku tidak ditemukan!');
        }

        if ($collection->available_stock < 1) {
            return redirect()->back()->with('error', 'Stok buku habis!');
        }

        if (!is_logged_in()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        // ================== PENGECEKAN KHUSUS MAHASISWA ==================
        if (!$this->isDosen()) {
            // Cek maksimal pinjam (PENDING + APPROVED)
            $activeCount = Order::where('user_id', user_id())
                ->whereIn('status', ['PENDING', 'APPROVED'])
                ->count();

            if ($activeCount >= self::MAX_BORROW_COUNT) {
                return redirect()->back()->with('error', "Anda sudah meminjam {$activeCount} buku. Maksimal " . self::MAX_BORROW_COUNT . " buku!");
            }

            // Validasi durasi pinjam
            $borrow = Carbon::parse($borrowDate);
            $due = Carbon::parse($returnDate);
            $daysDiff = $borrow->diffInDays($due);

            if ($daysDiff < 1) {
                return redirect()->back()->with('error', 'Minimal peminjaman 1 hari!');
            }

            if ($daysDiff > self::MAX_BORROW_DAYS) {
                return redirect()->back()->with('error', 'Maksimal peminjaman ' . self::MAX_BORROW_DAYS . ' hari!');
            }
        } else {
            // ================== PENGATURAN UNTUK DOSEN ==================
            $borrow = Carbon::parse($borrowDate);
            // Dosen bebas menentukan due_date, jika tidak diisi default 5 tahun
            $due = $returnDate ? Carbon::parse($returnDate) : now()->addYears(5);
        }

        // Cek duplikat (berlaku untuk semua)
        $existingOrder = Order::where('user_id', user_id())
            ->whereIn('status', ['PENDING', 'APPROVED'])
            ->whereHas('details', function ($q) use ($collection) {
                $q->where('collection_id', $collection->id);
            })
            ->exists();

        if ($existingOrder) {
            return redirect()->back()->with('error', 'Buku sudah Anda pinjam atau sedang dalam proses konfirmasi!');
        }

        DB::beginTransaction();

        // Buat order
        $order = Order::create([
            'user_id'            => user_id(),
            'order_date'         => Carbon::now()->format('Y-m-d'),
            'borrow_date'        => $borrow->format('Y-m-d'),
            'due_date'           => $due->format('Y-m-d'),
            'actual_return_date' => null,
            'fine'               => 0,
            'is_extended'        => 0,
            'extended_until'     => null,
            'extend_days'        => 0,
            'original_due_date'  => null,
            'status'             => 'PENDING',
        ]);

        Log::info("Order created with ID: {$order->id}");

        // Buat order detail
        $detail = $order->details()->create([
            'collection_id' => $collection->id,
            'qty' => 1
        ]);

        Log::info("Order detail created with ID: {$detail->id}");

        DB::commit();

        return redirect()->back()->with('success', 'Peminjaman berhasil diajukan! Menunggu persetujuan admin.');
    }

    // ================= ADMIN APPROVE =================
    public function approve($id)
    {
        $order = Order::findOrFail($id);

        // Isi tanggal pinjam dan jatuh tempo jika masih NULL
        if (!$order->borrow_date) {
            $order->borrow_date = now();
        }

        if (!$order->due_date) {
            // Set jatuh tempo 14 hari dari tanggal pinjam (untuk mahasiswa) atau 5 tahun untuk dosen?
            // Karena di store kita sudah set due_date, seharusnya tidak null.
            // Tetap beri default 14 hari jika kosong (fallback).
            $order->due_date = $order->borrow_date->copy()->addDays(14);
        }

        $order->status = 'APPROVED';
        $order->save();

        foreach ($order->details as $detail) {
            $collection = $detail->collection;
            if ($collection->available_stock >= $detail->qty) {
                $collection->available_stock -= $detail->qty;
                $collection->save();
            } else {
                return back()->with('error', 'Stok buku tidak mencukupi untuk ' . $collection->title);
            }
        }

        $judul = $order->details->first()->collection->title ?? 'buku';
        $this->sendNotif(
            $order->user_id,
            'Peminjaman Disetujui',
            "Peminjaman \"{$judul}\" telah disetujui. Batas pengembalian: " . $order->due_date->format('d M Y')
        );

        return redirect()->back()->with('success', 'Peminjaman berhasil disetujui');
    }

    // ================= ADMIN REJECT =================
    public function reject($id)
    {
        $order = Order::findOrFail($id);

        $order->update([
            'status' => 'REJECTED'
        ]);

        $judul = $order->details->first()->collection->title ?? 'buku';
        $this->sendNotif(
            $order->user_id,
            'Peminjaman Ditolak',
            "Peminjaman \"{$judul}\" telah ditolak."
        );

        return back()->with('success', 'Peminjaman ditolak');
    }

    // ================= ADMIN EXTEND (PERPANJANGAN) =================
    public function extend(Request $request, $id)
    {
        $request->validate([
            'extend_days' => 'required|integer|min:1|max:' . self::EXTEND_DAYS
        ]);

        $order = Order::findOrFail($id);

        // Dosen tidak perlu perpanjangan
        if ($this->isDosenByOrder($order)) {
            return back()->with('error', 'Dosen tidak memerlukan perpanjangan karena masa pinjam bebas.');
        }

        // Cek apakah bisa perpanjang
        $canExtendResult = $this->canExtend($order);
        if ($canExtendResult !== true) {
            return back()->with('error', $canExtendResult);
        }

        DB::transaction(function () use ($order, $request) {
            $extendDays = (int) $request->extend_days;
            $oldDueDate = Carbon::parse($order->due_date);
            $newDueDate = $oldDueDate->copy()->addDays($extendDays);

            $currentExtendCount = (int)($order->extend_days / self::EXTEND_DAYS);
            $newExtendCount = $currentExtendCount + 1;
            $newExtendDays = $order->extend_days + $extendDays;

            if ($order->extend_days == 0) {
                $order->original_due_date = $order->due_date;
            }

            $order->update([
                'due_date'       => $newDueDate,
                'is_extended'    => 1,
                'extended_until' => $newDueDate,
                'extend_days'    => $newExtendDays,
            ]);

            $this->sendNotif(
                $order->user_id,
                'Perpanjangan Disetujui',
                "Perpanjangan {$extendDays} hari disetujui. Batas pengembalian baru: " . $newDueDate->format('d M Y') . " (Perpanjangan ke-{$newExtendCount} dari maksimal " . self::MAX_EXTEND_COUNT . ")"
            );
        });

        return back()->with('success', "Perpanjangan {$request->extend_days} hari berhasil");
    }

    /**
     * Cek apakah order bisa diperpanjang (untuk mahasiswa)
     */
    private function canExtend($order)
    {
        $extendCount = (int)($order->extend_days / self::EXTEND_DAYS);

        if ($extendCount >= self::MAX_EXTEND_COUNT) {
            return 'Maksimal perpanjangan sudah ' . self::MAX_EXTEND_COUNT . ' kali';
        }

        if ($order->status !== 'APPROVED') {
            return 'Status peminjaman tidak valid untuk perpanjangan';
        }

        if ($order->actual_return_date) {
            return 'Buku sudah dikembalikan';
        }

        if (Carbon::now()->gt($order->due_date)) {
            return 'Sudah melewati jatuh tempo, tidak bisa perpanjang. Silakan kembalikan buku dan bayar denda.';
        }

        return true;
    }

    // ================= RETURN BOOK =================
    public function returnBook($id)
    {
        // Muat user beserta role
        $order = Order::with(['details.collection', 'user.role'])->findOrFail($id);
        $today = Carbon::now();

        // Hitung denda otomatis
        $dueDate = Carbon::parse($order->due_date)->startOfDay();
        $returnDate = $today->startOfDay();
        $lateDays = $dueDate->diffInDays($returnDate, false);

        $fine = 0;
        if ($lateDays > 0) {
            // Jika peminjam adalah dosen, denda = 0
            if ($order->user && $order->user->role && $order->user->role->name === 'Dosen') {
                $fine = 0;
            } else {
                // Perhitungan denda mahasiswa
                for ($i = 1; $i <= $lateDays; $i++) {
                    $fine += ($i <= 3) ? 2000 : 5000;
                }
            }
        }

        // Update stok
        foreach ($order->details as $detail) {
            $detail->collection->increment('available_stock', $detail->qty);
        }

        // Update order
        $order->update([
            'actual_return_date' => $today,
            'fine'               => $fine,
            'status'             => 'RETURNED'
        ]);

        // Notifikasi
        $judul = $order->details->first()->collection->title ?? 'buku';
        $message = "Buku \"{$judul}\" telah dikembalikan.";
        if ($fine > 0) {
            $message .= ' Total denda: Rp ' . number_format($fine, 0, ',', '.');
        }
        $this->sendNotif($order->user_id, 'Pengembalian Berhasil', $message);

        return back()->with('success', $message);
    }

    // ================= HISTORY USER =================
    public function history()
    {
        $orders = Order::with('details.collection')
            ->where('user_id', user_id())
            ->latest()
            ->get();

        return view('user.page.history', compact('orders'));
    }

    // ================= HELPER =================

    /**
     * Cek apakah user yang sedang login adalah dosen (dari session)
     */
    private function isDosen(): bool
    {
        $user = session('user');
        return $user && ($user['role']['name'] ?? '') === 'Dosen';
    }

    /**
     * Cek apakah pemilik order adalah dosen (dari relasi)
     */
    private function isDosenByOrder($order): bool
    {
        return $order->user && $order->user->role && $order->user->role->name === 'Dosen';
    }

    private function sendNotif($userId, $title, $message)
    {
        Notification::create([
            'user_id' => $userId,
            'title'   => $title,
            'message' => $message,
        ]);

        $user = User::find($userId);
        if ($user && $user->email) {
            Mail::raw($message, function ($mail) use ($user, $title) {
                $mail->to($user->email)
                     ->subject('Notifikasi: ' . $title);
            });
        }
    }

    // Method calculateFine tetap dipertahankan, bisa digunakan jika perlu
    private function calculateFine($due, $return)
    {
        $dueDate = Carbon::parse($due)->startOfDay();
        $returnDate = Carbon::parse($return)->startOfDay();
        $lateDays = $dueDate->diffInDays($returnDate, false);

        if ($lateDays <= 0) {
            return 0;
        }

        $fine = 0;
        for ($i = 1; $i <= $lateDays; $i++) {
            $fine += ($i <= 3) ? 2000 : 5000;
        }
        return $fine;
    }
}
