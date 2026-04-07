<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Collection;
use App\Models\Location;
use Carbon\Carbon;

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
        $collection = Collection::findOrFail($request->collection_id);

        if ($collection->stock <= 0) {
            return back()->with('error', 'Stok buku habis');
        }

        $start = Carbon::parse($request->order_date);
        $end = Carbon::parse($request->return_date);

        if ($start->diffInDays($end) > 14) {
            return back()->with('error', 'Maksimal peminjaman 14 hari');
        }

        $order = Order::create([
            'user_id' => auth()->id(),
            'order_date' => $start,
            'return_date' => $end,
            'status' => 'PENDING'
        ]);

        OrderDetail::create([
            'order_id' => $order->id,
            'collection_id' => $collection->id,
            'qty' => 1
        ]);

        return back()->with('success', 'Pengajuan peminjaman dikirim');
    }

    // ================= ADMIN APPROVE =================
    public function approve($id)
    {
        $order = Order::with('details.collection')->findOrFail($id);

        foreach ($order->details as $detail) {
            if ($detail->collection->stock < $detail->qty) {
                return back()->with('error', 'Stok tidak cukup');
            }
        }

        foreach ($order->details as $detail) {
            $detail->collection->decrement('stock', $detail->qty);
        }

        $order->update([
            'status' => 'APPROVED'
        ]);

        return back()->with('success', 'Peminjaman disetujui');
    }

    // ================= ADMIN REJECT =================
    public function reject($id)
    {
        $order = Order::findOrFail($id);
        $order->update(['status' => 'REJECTED']);
        return back()->with('success', 'Peminjaman ditolak');
    }

    // ================= HITUNG DENDA =================
    private function calculateFine($due, $return)
    {
        $lateDays = Carbon::parse($due)->diffInDays($return, false);

        if ($lateDays <= 0) return 0;

        if ($lateDays <= 3) return $lateDays * 1000;
        if ($lateDays <= 7) return $lateDays * 2000;
        return $lateDays * 5000;
    }

    // ================= RETURN =================
    public function returnBook($id)
    {
        $order = Order::with('details.collection')->findOrFail($id);
        $today = now();
        $fine = $this->calculateFine($order->return_date, $today);

        foreach ($order->details as $detail) {
            $detail->collection->increment('stock', $detail->qty);
        }

        $order->update([
            'actual_return_date' => $today,
            'fine' => $fine,
            'status' => 'RETURNED'
        ]);

        return back()->with('success', 'Buku dikembalikan');
    }

    // ================= PERPANJANG =================
    public function extend($id)
    {
        $order = Order::with('details.collection')->findOrFail($id);
        $today = now();
        $due = Carbon::parse($order->return_date);

        if ($today > $due) {
            return back()->with('error', 'Sudah terlambat, tidak bisa perpanjang');
        }

        if ($today->lt($due->copy()->subDay())) {
            return back()->with('error', 'Perpanjangan hanya bisa H-1');
        }

        if ($order->extension_count >= 2) {
            return back()->with('error', 'Maksimal perpanjangan 2x');
        }

        foreach ($order->details as $detail) {
            $dipakai = OrderDetail::where('collection_id', $detail->collection_id)
                ->whereHas('order', fn($q) => $q->where('status', 'APPROVED'))
                ->exists();

            if ($dipakai) return back()->with('error', 'Buku sedang dipinjam orang lain');
        }

        $order->update([
            'return_date' => $due->addDays(7),
            'extension_count' => $order->extension_count + 1
        ]);

        return back()->with('success', 'Perpanjangan berhasil 7 hari');
    }
}