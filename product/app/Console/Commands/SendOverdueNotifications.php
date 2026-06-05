<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use App\Models\Notification;
use Carbon\Carbon;

class SendOverdueNotifications extends Command
{
    protected $signature = 'notifications:overdue';
    protected $description = 'Kirim notifikasi peringatan jatuh tempo dan denda harian';

    public function handle()
    {
        $today = Carbon::now()->startOfDay();

        // 1. Peringatan 1 hari sebelum jatuh tempo
        $tomorrow = $today->copy()->addDay();
        $warningOrders = Order::where('status', 'APPROVED')
            ->whereDate('due_date', $tomorrow)
            ->where('due_warning_sent', false)
            ->get();

        foreach ($warningOrders as $order) {
            $judul = $order->details->first()?->collection->title ?? 'buku';
            Notification::create([
                'user_id' => $order->user_id,
                'title' => 'Jatuh Tempo Besok',
                'message' => "Peminjaman \"{$judul}\" akan jatuh tempo besok ({$tomorrow->format('d M Y')}). Harap segera dikembalikan."
            ]);
            $order->update(['due_warning_sent' => true]);
        }

        $this->info("Peringatan jatuh tempo terkirim untuk {$warningOrders->count()} order.");

        // 2. Denda harian untuk yang sudah terlambat
        $overdueOrders = Order::where('status', 'APPROVED')
            ->whereDate('due_date', '<', $today)
            ->whereNull('actual_return_date')
            ->get();

        foreach ($overdueOrders as $order) {
            $lateDays = Carbon::parse($order->due_date)->diffInDays($today);
            $fine = 0;
            for ($i = 1; $i <= $lateDays; $i++) {
                $fine += ($i <= 3) ? 2000 : 5000;
            }

            // Cek apakah sudah kirim notifikasi denda hari ini
            $lastSent = $order->fine_notification_sent_at ? Carbon::parse($order->fine_notification_sent_at)->startOfDay() : null;
            if ($lastSent && $lastSent->eq($today)) {
                continue; // sudah dikirim hari ini
            }

            $judul = $order->details->first()?->collection->title ?? 'buku';
            Notification::create([
                'user_id' => $order->user_id,
                'title' => 'Denda Keterlambatan',
                'message' => "Anda terlambat mengembalikan \"{$judul}\" ({$lateDays} hari). Total denda saat ini: Rp " . number_format($fine, 0, ',', '.')
            ]);

            // Update tanggal notifikasi denda terakhir (per order, bukan simpan fine)
            $order->update(['fine_notification_sent_at' => now()]);
        }

        $this->info("Notifikasi denda terkirim untuk {$overdueOrders->count()} order.");
    }
}
