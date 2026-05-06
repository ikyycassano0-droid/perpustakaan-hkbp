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

class OrderController extends Controller
{
    // ================= KONSTANTA =================
    const MAX_BORROW_DAYS = 3;        // Maksimal durasi pinjam 3 hari
    const MAX_BORROW_COUNT = 3;       // Maksimal 3 buku aktif
    const MAX_EXTEND_COUNT = 3;       // Maksimal perpanjangan 3 kali
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
        
        try {
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
            
            if (!auth()->check()) {
                return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
            }
            
            // Cek maksimal pinjam (PENDING + APPROVED) - DARI SEMUA JENIS BUKU
            $activeCount = Order::where('user_id', auth()->id())
                ->whereIn('status', ['PENDING', 'APPROVED'])
                ->count();
            
            if ($activeCount >= self::MAX_BORROW_COUNT) {
                return redirect()->back()->with('error', "Anda sudah meminjam {$activeCount} buku. Maksimal " . self::MAX_BORROW_COUNT . " buku!");
            }
            
            // Cek duplikat (buku yang sama, status PENDING atau APPROVED)
            $existingOrder = Order::where('user_id', auth()->id())
                ->whereIn('status', ['PENDING', 'APPROVED'])
                ->whereHas('details', function ($q) use ($collection) {
                    $q->where('collection_id', $collection->id);
                })
                ->exists();
            
            if ($existingOrder) {
                return redirect()->back()->with('error', 'Buku sudah Anda pinjam atau sedang dalam proses konfirmasi!');
            }
            
            // Validasi durasi pinjam (MAX 3 HARI)
            $borrow = Carbon::parse($borrowDate);
            $due = Carbon::parse($returnDate);
            $daysDiff = $borrow->diffInDays($due);
            
            if ($daysDiff < 1) {
                return redirect()->back()->with('error', 'Minimal peminjaman 1 hari!');
            }
            
            if ($daysDiff > self::MAX_BORROW_DAYS) {
                return redirect()->back()->with('error', 'Maksimal peminjaman ' . self::MAX_BORROW_DAYS . ' hari!');
            }
            
            DB::beginTransaction();
            
            // Buat order
            $order = Order::create([
                'user_id'            => auth()->id(),
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
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Order store error: " . $e->getMessage());
            Log::error($e->getTraceAsString());
            
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // ================= ADMIN APPROVE =================
    public function approve($id)
    {
        DB::transaction(function () use ($id) {
            $order = Order::with('details.collection')->findOrFail($id);

            foreach ($order->details as $detail) {
                if ($detail->collection->available_stock < $detail->qty) {
                    throw new \Exception('Stok tidak cukup');
                }
            }

            foreach ($order->details as $detail) {
                $detail->collection->decrement('available_stock', $detail->qty);

                $this->sendNotif(
                    $order->user_id,
                    'Peminjaman Disetujui',
                    'Buku "' . $detail->collection->title . '" disetujui. Batas pengembalian: ' . Carbon::parse($order->due_date)->format('d M Y')
                );
            }

            $order->update([
                'status' => 'APPROVED',
            ]);
        });

        return back()->with('success', 'Peminjaman disetujui');
    }

    // ================= ADMIN REJECT =================
    public function reject($id)
    {
        $order = Order::findOrFail($id);

        $order->update([
            'status' => 'REJECTED'
        ]);

        $this->sendNotif(
            $order->user_id,
            'Peminjaman Ditolak',
            'Mohon maaf, peminjaman buku Anda ditolak.'
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

        // Cek apakah bisa perpanjang
        $canExtendResult = $this->canExtend($order);
        if ($canExtendResult !== true) {
            return back()->with('error', $canExtendResult);
        }

        DB::transaction(function () use ($order, $request) {
            $extendDays = $request->extend_days;
            $oldDueDate = Carbon::parse($order->due_date);
            $newDueDate = $oldDueDate->copy()->addDays($extendDays);

            // Hitung perpanjangan ke berapa (total_extend_days / 3)
            $currentExtendCount = (int)($order->extend_days / self::EXTEND_DAYS);
            $newExtendCount = $currentExtendCount + 1;
            $newExtendDays = $order->extend_days + $extendDays;

            // Simpan original due date jika pertama kali perpanjang
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
     * Cek apakah order bisa diperpanjang
     * @return true|string
     */
    private function canExtend($order)
    {
        // Hitung sudah berapa kali perpanjangan
        $extendCount = (int)($order->extend_days / self::EXTEND_DAYS);
        
        // Maksimal perpanjangan 3 kali
        if ($extendCount >= self::MAX_EXTEND_COUNT) {
            return 'Maksimal perpanjangan sudah ' . self::MAX_EXTEND_COUNT . ' kali';
        }
        
        // Status harus APPROVED
        if ($order->status !== 'APPROVED') {
            return 'Status peminjaman tidak valid untuk perpanjangan';
        }
        
        // Belum dikembalikan
        if ($order->actual_return_date) {
            return 'Buku sudah dikembalikan';
        }
        
        // Belum lewat due date (masih bisa perpanjang sebelum jatuh tempo)
        if (Carbon::now()->gt($order->due_date)) {
            return 'Sudah melewati jatuh tempo, tidak bisa perpanjang. Silakan kembalikan buku dan bayar denda.';
        }
        
        return true;
    }

    // ================= RETURN BOOK =================
    public function returnBook($id)
    {
        DB::transaction(function () use ($id) {
            $order = Order::with('details.collection')->findOrFail($id);

            $today = Carbon::now();
            $fine = $this->calculateFine($order->due_date, $today);

            foreach ($order->details as $detail) {
                $detail->collection->increment('available_stock', $detail->qty);
            }

            $order->update([
                'actual_return_date' => $today,
                'fine' => $fine,
                'status' => 'RETURNED'
            ]);

            if ($fine > 0) {
                $this->sendNotif(
                    $order->user_id,
                    'Denda Keterlambatan',
                    'Denda Rp ' . number_format($fine, 0, ',', '.')
                );
            }
            
            $this->sendNotif(
                $order->user_id,
                'Pengembalian Buku',
                'Buku berhasil dikembalikan. Terima kasih.'
            );
        });

        return back()->with('success', 'Buku berhasil dikembalikan');
    }

    // ================= HISTORY USER =================
    public function history()
    {
        $orders = Order::with('details.collection')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('user.page.history', compact('orders'));
    }

    // ================= HITUNG DENDA =================
    // Denda: 3 hari pertama @2000, hari berikutnya @5000
    private function calculateFine($due, $return)
    {
        $lateDays = Carbon::parse($due)->diffInDays($return, false);
        if ($lateDays <= 0) return 0;

        $fine = 0;
        for ($i = 1; $i <= $lateDays; $i++) {
            $fine += ($i <= 3) ? 2000 : 5000;
        }
        return $fine;
    }

    // ================= NOTIF =================
    private function sendNotif($userId, $title, $message)
    {
        Notification::create([
            'user_id' => $userId,
            'title' => $title,
            'message' => $message,
        ]);
    }
}