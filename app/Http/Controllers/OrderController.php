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
        $orders = Order::with(['user','details.collection.location'])
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
    try {

        $request->validate([
            'collection_id' => 'required|exists:collections,id',
            'borrow_date'   => 'required|date|after_or_equal:today',
            'return_date'   => 'required|date|after:borrow_date',
        ]);

        if (!auth()->check()) {
            return back()->with('error', 'Silakan login');
        }

        $collection = Collection::findOrFail($request->collection_id);

        if ($collection->available_stock < 1) {
            return back()->with('error', 'Stock habis');
        }

        $borrow = Carbon::parse($request->borrow_date);
        $return = Carbon::parse($request->return_date);

        $maxAllowedReturn = $borrow->copy()->addDays(7);

        if ($return->gt($maxAllowedReturn)) {
            return back()->with('error', 'Maksimal 7 hari');
        }

        DB::transaction(function () use ($request, $collection, $borrow, $return) {

            $order = Order::create([
                'user_id'        => auth()->id(),
                'order_date'     => now(),
                'borrow_date'    => $borrow,
                'due_date'       => $return,
                'status'         => 'PENDING',
                'fine'           => 0,
                'extension_count'=> 0,
            ]);

            OrderDetail::create([
                'order_id'      => $order->id,
                'collection_id' => $collection->id,
                'qty'           => 1
            ]);

            // ❌ MATIKAN DULU NOTIF (INI SERING JADI BIANG)
            // foreach (\App\Models\User::where('role', 'admin')->get() as $admin) {
            //     Notification::create([
            //         'user_id' => $admin->id,
            //         'title'   => 'Pengajuan Peminjaman',
            //         'message' => auth()->user()->name . ' meminjam "' . $collection->title . '"'
            //     ]);
            // }

        });

        return back()->with('success', 'BERHASIL MASUK DB');

    } catch (\Exception $e) {

        return back()->with('error', 'ERROR: ' . $e->getMessage());
    }
}
    // ================= ADMIN APPROVE =================
    public function approve($id)
    {
        DB::transaction(function () use ($id) {

            $order = Order::with('details.collection')->findOrFail($id);

            foreach ($order->details as $detail) {
                if ($detail->collection->available_stock < $detail->qty) {
                    throw new \Exception('Stock tidak cukup');
                }
            }

            foreach ($order->details as $detail) {
                $detail->collection->decrement('available_stock', $detail->qty);

                $this->sendNotif(
                    $order->user_id,
                    'Peminjaman Disetujui',
                    'Buku "' . $detail->collection->title . '" disetujui'
                );
            }

            $order->update([
                'status' => 'APPROVED',
            ]);
        });

        return back()->with('success', 'Disetujui');
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

    // ================= RETURN BOOK =================
    public function returnBook($id)
    {
        DB::transaction(function () use ($id) {

            $order = Order::with('details.collection')->findOrFail($id);

            $today = now();
            $fine = $this->calculateFine($order->due_date, $today);

            foreach ($order->details as $detail) {
                $detail->collection->increment('available_stock', $detail->qty);

                $this->sendNotif(
                    $order->user_id,
                    'Pengembalian',
                    'Buku "' . $detail->collection->title . '" dikembalikan'
                );
            }

            if ($fine > 0) {
                $this->sendNotif(
                    $order->user_id,
                    'Denda',
                    'Denda Rp ' . number_format($fine)
                );
            }

            $order->update([
                'actual_return_date' => $today,
                'fine' => $fine,
                'status' => 'RETURNED'
            ]);
        });

        return back()->with('success', 'Dikembalikan');
    }

    // ================= EXTEND =================
    public function extend($id)
    {
        $order = Order::with('details.collection')->findOrFail($id);

        $today = Carbon::now();
        $due = Carbon::parse($order->due_date);

        // ❌ 1. sudah jatuh tempo (telat)
        if ($today->gt($due)) {
            return back()->with('error', 'Tidak bisa perpanjang karena sudah melewati jatuh tempo');
        }

        // ❌ 2. sudah pernah perpanjangan
        if ($order->extension_count >= 1) {
            return back()->with('error', 'Peminjaman ini sudah pernah diperpanjang (maksimal 1 kali)');
        }

        // ❌ 3. harus H-1 saja (lebih ketat)
        if ($today->lt($due->copy()->subDay())) {
            return back()->with('error', 'Perpanjangan hanya bisa dilakukan H-1 sebelum jatuh tempo');
        }

        DB::transaction(function () use ($order, $due) {

            // 🔥 tambah 7 hari dari due_date lama
            $newDue = Carbon::parse($order->due_date)->addDays(7);

            $order->update([
                'due_date' => $newDue,
                'extension_count' => $order->extension_count + 1
            ]);

            $this->sendNotif(
                $order->user_id,
                'Perpanjangan Disetujui',
                'Masa pinjam diperpanjang sampai ' . $newDue->format('d M Y')
            );
        });

        return back()->with('success', 'Perpanjangan berhasil');
    }
    // ================= HISTORY =================
    public function history()
    {
        $orders = Order::with('details.collection')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('user.page.history', compact('orders'));
    }

    // ================= FINE CALC =================
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