@extends('user.component.master')

@section('title', 'History Peminjaman')

@section('user_content')
    <div class="container py-4">
        <h3 class="mb-4">📚 History Peminjaman</h3>

        <div class="row">
            @foreach($orders as $order)
                @foreach($order->details as $detail)
                    @php
                        $due = \Carbon\Carbon::parse($order->return_date);
                    @endphp

                    <div class="col-md-4 mb-4">
                        <div class="card shadow-lg border-0 rounded-4 h-100">
                            <div class="card-body">
                                <h5 class="fw-bold">{{ $detail->collection->title }}</h5>
                                <p class="mb-1">
                                    📅 Pinjam: {{ $order->order_date->format('d M Y') }}
                                </p>
                                <p class="mb-2">
                                    ⏳ Deadline: {{ $due->format('d M Y') }}
                                </p>

                                <!-- COUNTDOWN -->
                                <div class="countdown fw-bold"
                                     data-date="{{ $due->format('Y-m-d H:i:s') }}"
                                     data-status="{{ $order->status }}">
                                </div>

                                <!-- STATUS -->
                                @if($order->status == 'PENDING')
                                    <span class="badge bg-warning">Menunggu</span>
                                @elseif($order->status == 'APPROVED')
                                    <span class="badge bg-success">Dipinjam</span>
                                @elseif($order->status == 'REJECTED')
                                    <span class="badge bg-danger">Ditolak</span>
                                @elseif($order->status == 'RETURNED')
                                    <span class="badge bg-secondary">Selesai</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @endforeach
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            updateCountdown();
            setInterval(updateCountdown, 1000);
        });

        function updateCountdown() {
            document.querySelectorAll('.countdown').forEach(el => {
                let status = el.dataset.status;

                // 🔥 STOP kalau bukan APPROVED
                if (status !== 'APPROVED') {
                    el.innerHTML = ""; // kosongkan
                    return;
                }

                let endDate = new Date(el.dataset.date);
                let now = new Date();

                let diff = endDate - now;

                let days = Math.floor(diff / (1000 * 60 * 60 * 24));
                let hours = Math.floor((diff / (1000 * 60 * 60)) % 24);

                el.classList.remove('text-danger', 'text-warning', 'text-success');

                if (diff < 0) {
                    el.innerHTML = `❌ Terlambat ${Math.abs(days)} hari`;
                    el.classList.add('text-danger');

                    showNotif("Buku sudah lewat deadline!", "danger");
                } else if (days <= 1) {
                    el.innerHTML = `⚠️ ${days} hari ${hours} jam lagi`;
                    el.classList.add('text-warning');

                    showNotif("Buku hampir jatuh tempo!", "warning");
                } else {
                    el.innerHTML = `⏳ ${days} hari ${hours} jam`;
                    el.classList.add('text-success');
                }
            });
        }

        function showNotif(message, type) {
            if (localStorage.getItem(message)) return;

            let notif = document.createElement('div');
            notif.className = `alert alert-${type} position-fixed`;
            notif.style.top = "20px";
            notif.style.right = "20px";
            notif.style.zIndex = "9999";

            notif.innerHTML = message;

            document.body.appendChild(notif);

            setTimeout(() => notif.remove(), 4000);

            localStorage.setItem(message, true);
        }
    </script>
@endsection
