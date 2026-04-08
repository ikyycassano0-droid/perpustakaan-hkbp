<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckDueBooks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-due-books';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $orders = Order::with('details.collection')
            ->where('status', 'APPROVED')
            ->get();

        foreach ($orders as $order) {

            $due = Carbon::parse($order->return_date);

            if (now()->diffInDays($due, false) == 1) {

                foreach ($order->details as $detail) {

                    Notification::create([
                        'user_id' => $order->user_id,
                        'title' => 'Pengingat Pengembalian',
                        'message' => 'Besok adalah batas pengembalian buku "' .
                            $detail->collection->title . '"'
                    ]);
                }
            }
        }
    }
}
