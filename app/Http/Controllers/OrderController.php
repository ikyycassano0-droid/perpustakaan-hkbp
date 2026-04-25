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

class OrderController extends Controller
{
    // ================= ADMIN =================
    public function index()
    {
        $orders = Order::with(['user','details.collection.location'])->latest()->get();
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
        $request->validate([
            'collection_id' => 'required|exists:collections,id',
            'order_date' => 'required|date',
            'return_date' => 'required|date|after:order_date',
        ]);

        if (!auth()->check()) {
            return back()->with('error', 'Silakan login terlebih dahulu');
        }

        $collection = Collection::findOrFail($request->collection_id);

        if ($collection->stock <= 0) {
            return back()->with('error', 'Stok buku habis');
        }

        // 🔥 BATAS PINJAM (misalnya max 3 buku aktif)
        $activeOrders = Order::where('user_id', auth()->id())
            ->whereIn('status', ['PENDING','APPROVED'])
            ->count();

        if ($activeOrders >= 3) {
            return back()->with('error', 'Maksimal 3 buku aktif');
        }

        $start = Carbon::parse($request->order_date);
        $end = Carbon::parse($request->return_date);

        if ($start->diffInDays($end) > 14) {
            return back()->with('error', 'Maksimal peminjaman 14 hari');
        }

        DB::transaction(function () use ($request, $collection, $start, $end) {

            $order = Order::create([
                'user_id' => auth()->id(),
                'order_date' => $start,
                'return_date' => $end,
                'status' => 'PENDING',
                'fine' => 0,
                'extension_count' => 0,
            ]);

            OrderDetail::create([
                'order_id' => $order->id,
                'collection_id' => $collection->id,
                'qty' => 1
            ]);
        });

        return back()->with('success', 'Pengajuan peminjaman dikirim');
    }

    // ================= ADMIN APPROVE =================
    public function approve($id)
    {
        DB::transaction(function () use ($id) {

            $order = Order::with('details.collection')->findOrFail($id);

            foreach ($order->details as $detail) {
                if ($detail->collection->stock < $detail->qty) {
                    throw new \Exception('Stok tidak cukup');
                }
            }

            foreach ($order->details as $detail) {
                $detail->collection->decrement('stock', $detail->qty);

                $this->sendNotif(
                    $order->user_id,
                    'Peminjaman Disetujui',
                    'Buku "' . $detail->collection->title . '" siap diambil'
                );
            }

            $order->update([
                'status' => 'APPROVED'
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

        return back()->with('success', 'Peminjaman ditolak');
    }

    // ================= RETURN =================
    public function returnBook($id)
    {
        DB::transaction(function () use ($id) {

            $order = Order::with('details.collection')->findOrFail($id);

            $today = now();
            $fine = $this->calculateFine($order->return_date, $today);

            foreach ($order->details as $detail) {
                $detail->collection->increment('stock', $detail->qty);

                $this->sendNotif(
                    $order->user_id,
                    'Pengembalian Buku',
                    'Buku "' . $detail->collection->title . '" berhasil dikembalikan'
                );

                if ($fine > 0) {
                    $lateDays = Carbon::parse($order->return_date)->diffInDays($today);

                    $this->sendNotif(
                        $order->user_id,
                        'Denda',
                        'Denda Rp ' . number_format($fine) .
                        ' (' . $lateDays . ' hari terlambat)'
                    );
                }
            }

            $order->update([
                'actual_return_date' => $today,
                'fine' => $fine,
                'status' => 'RETURNED'
            ]);
        });

        return back()->with('success', 'Buku dikembalikan');
    }

    // ================= PERPANJANG =================
    public function extend($id)
    {
        $order = Order::with('details.collection')->findOrFail($id);

        $today = now();
        $due = Carbon::parse($order->return_date);

        if ($today > $due) {
            return back()->with('error', 'Tidak bisa perpanjang, sudah terlambat');
        }

        if ($order->extension_count >= 2) {
            return back()->with('error', 'Maksimal 2x perpanjangan');
        }

        $order->update([
            'return_date' => $due->addDays(7),
            'extension_count' => $order->extension_count + 1
        ]);

        foreach ($order->details as $detail) {
            $this->sendNotif(
                $order->user_id,
                'Perpanjangan',
                'Buku "' . $detail->collection->title . '" diperpanjang 7 hari'
            );
        }

        return back()->with('success', 'Perpanjangan berhasil');
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

    // ================= DENDA =================
    private function calculateFine($due, $return)
    {
        $lateDays = Carbon::parse($due)->diffInDays($return, false);

        if ($lateDays <= 0) return 0;
        if ($lateDays <= 3) return $lateDays * 1000;
        if ($lateDays <= 7) return $lateDays * 2000;

        return $lateDays * 5000;
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