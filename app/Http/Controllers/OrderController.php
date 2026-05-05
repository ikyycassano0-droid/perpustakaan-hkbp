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
        try {

            // VALIDASI
            $request->validate([
                'collection_id' => 'required|exists:collections,id',
                'borrow_date'   => 'required|date|after_or_equal:today',
                'return_date'   => 'required|date|after:borrow_date',
            ]);

            if (!auth()->check()) {
                return back()->with('error', 'Silakan login terlebih dahulu');
            }

            $collection = Collection::findOrFail($request->collection_id);

            if ($collection->available_stock < 1) {
                return back()->with('error', 'Stok buku habis');
            }

            // CEK DUPLIKAT PINJAM
            if (!Order::canBorrow(auth()->id(), $collection->id)) {
                return back()->with('error', 'Buku masih dalam proses atau sudah kamu pinjam');
            }

            $borrow = Carbon::parse($request->borrow_date);
            $return = Carbon::parse($request->return_date);

            // MAX 7 HARI
            if ($return->gt($borrow->copy()->addDays(7))) {
                return back()->with('error', 'Maksimal peminjaman hanya 7 hari');
            }

            DB::transaction(function () use ($collection, $borrow, $return) {

                // ================= ORDER (HEADER) =================
                $order = Order::create([
                    'user_id'         => auth()->id(),
                    'order_date'      => now(),
                    'due_date'        => $return,
                    'return_date'     => $return,
                    'status'          => 'PENDING',
                    'fine'            => 0,
                    'extension_count' => 0,
                ]);

                // ================= ORDER DETAIL =================
                $order->details()->create([
                    'collection_id' => $collection->id,
                    'qty'           => 1
                ]);
            });

            return back()->with('success', 'Peminjaman berhasil diajukan');

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
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
                    'Buku "' . $detail->collection->title . '" disetujui'
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
                    'Pengembalian Buku',
                    'Buku "' . $detail->collection->title . '" telah dikembalikan'
                );
            }

            if ($fine > 0) {
                $this->sendNotif(
                    $order->user_id,
                    'Denda Keterlambatan',
                    'Denda Rp ' . number_format($fine)
                );
            }

            $order->update([
                'actual_return_date' => $today,
                'fine'               => $fine,
                'status'             => 'RETURNED'
            ]);
        });

        return back()->with('success', 'Buku berhasil dikembalikan');
    }

    // ================= EXTEND =================
    public function extend($id)
    {
        $order = Order::findOrFail($id);

        $today = Carbon::now();
        $due = Carbon::parse($order->due_date);

        if ($today->gt($due)) {
            return back()->with('error', 'Sudah lewat jatuh tempo');
        }

        if ($order->extension_count >= 1) {
            return back()->with('error', 'Maksimal 1 kali perpanjangan');
        }

        if ($today->lt($due->copy()->subDay())) {
            return back()->with('error', 'Perpanjangan hanya bisa H-1');
        }

        DB::transaction(function () use ($order) {

            $newDue = Carbon::parse($order->due_date)->addDays(7);

            $order->update([
                'due_date' => $newDue,
                'extension_count' => $order->extension_count + 1
            ]);

            $this->sendNotif(
                $order->user_id,
                'Perpanjangan Disetujui',
                'Batas pengembalian diperpanjang sampai ' . $newDue->format('d M Y')
            );
        });

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

    // ================= HITUNG DENDA =================
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
            'title'   => $title,
            'message' => $message,
        ]);
    }
}