@extends('user.component.master')

@section('title', 'Inbox Notifikasi - AKPER HKBP Balige')

@push('styles')
    <style>
        .inbox-container {
            max-width: 800px;
            margin: 0 auto;
        }

        .notif-card {
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(12px);
            border-radius: 1rem;
            border: 1px solid rgba(99, 102, 241, 0.3);
            margin-bottom: 0.75rem;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .notif-card:hover {
            border-color: rgba(99, 102, 241, 0.7);
            transform: translateX(5px);
        }

        .notif-card.unread {
            border-left: 4px solid #6366f1;
            background: rgba(99, 102, 241, 0.1);
        }

        .notif-card.read {
            opacity: 0.7;
        }

        .notif-icon {
            font-size: 1.5rem;
            min-width: 40px;
        }

        .notif-title {
            font-weight: 600;
            color: #c7d2fe;
            font-size: 0.9rem;
        }

        .notif-message {
            color: #94a3b8;
            font-size: 0.8rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .notif-time {
            font-size: 0.7rem;
            color: #64748b;
            white-space: nowrap;
        }

        .section-title {
            color: #a5b4fc;
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 1.5rem 0 0.75rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid rgba(99, 102, 241, 0.3);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .section-count {
            font-size: 0.7rem;
            color: #64748b;
            font-weight: normal;
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #64748b;
        }

        .badge-unread {
            background: #6366f1;
            color: white;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 0.65rem;
            font-weight: 600;
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.5;
            }
        }

        .btn-mark-all {
            background: rgba(99, 102, 241, 0.2);
            border: 1px solid rgba(99, 102, 241, 0.4);
            color: #a5b4fc;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.75rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-mark-all:hover {
            background: rgba(99, 102, 241, 0.4);
            color: white;
        }

        /* Modal Detail */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(8px);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .modal-detail {
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(99, 102, 241, 0.5);
            border-radius: 1.5rem;
            padding: 2rem;
            width: 90%;
            max-width: 500px;
            transform: scale(0.9);
            transition: all 0.3s ease;
        }

        .modal-overlay.active .modal-detail {
            transform: scale(1);
        }

        .modal-icon {
            font-size: 3rem;
            text-align: center;
            margin-bottom: 1rem;
        }

        .modal-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #c7d2fe;
            text-align: center;
            margin-bottom: 0.5rem;
        }

        .modal-message {
            color: #94a3b8;
            text-align: center;
            line-height: 1.6;
            margin-bottom: 1rem;
        }

        .modal-time {
            text-align: center;
            color: #64748b;
            font-size: 0.8rem;
            margin-bottom: 1.5rem;
        }

        .btn-close {
            background: rgba(99, 102, 241, 0.3);
            border: 1px solid rgba(99, 102, 241, 0.5);
            color: #c7d2fe;
            padding: 10px 24px;
            border-radius: 30px;
            cursor: pointer;
            width: 100%;
            font-size: 0.85rem;
            transition: all 0.3s ease;
        }

        .btn-close:hover {
            background: rgba(99, 102, 241, 0.5);
            color: white;
        }
    </style>
@endpush

@section('content')
    <div class="main-content pt-28 px-5">
        <div class="inbox-container">

            {{-- HEADER --}}
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-indigo-300">
                        📬 Inbox Notifikasi
                    </h1>
                    <p class="text-gray-400 text-sm mt-1">
                        {{ $notifications->count() }} notifikasi ·
                        <span class="text-indigo-400">{{ $unreadCount }} belum dibaca</span>
                    </p>
                </div>
                @if($unreadCount > 0)
                    <button onclick="markAllRead()" class="btn-mark-all">
                        ✅ Tandai Semua Dibaca
                    </button>
                @endif
            </div>

            {{-- NOTIFIKASI --}}
            @php
                use Carbon\Carbon;
                $grouped = $notifications->groupBy(function($item) {
                    $date = Carbon::parse($item->created_at);
                    if ($date->isToday()) return 'Hari Ini';
                    if ($date->isYesterday()) return 'Kemarin';
                    if ($date->isCurrentWeek()) return 'Minggu Ini';
                    if ($date->isCurrentMonth()) return 'Bulan Ini';
                    return 'Lama';
                });
            @endphp

            @forelse($grouped as $group => $items)
                <div class="section-title">
                    <span>📌 {{ $group }}</span>
                    <span class="section-count">{{ $items->count() }} pesan</span>
                </div>

                @foreach($items as $notif)
                    <div class="notif-card p-4 {{ !$notif->is_read ? 'unread' : 'read' }}"
                         data-id="{{ $notif->id }}"
                         data-title="{{ $notif->title }}"
                         data-message="{{ $notif->message }}"
                         data-icon="{{ $notif->icon ?? '🔔' }}"
                         data-time="{{ Carbon::parse($notif->created_at)->format('d M Y, H:i') }}"
                         data-isread="{{ $notif->is_read ? '1' : '0' }}"
                         onclick="openDetail(this)">
                        <div class="flex gap-3">
                            <div class="notif-icon">
                                {{ $notif->icon ?? '🔔' }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-start gap-2">
                                    <span class="notif-title truncate">
                                        {{ $notif->title }}
                                        @if(!$notif->is_read)
                                            <span class="badge-unread ml-2">BARU</span>
                                        @endif
                                    </span>
                                    <span class="notif-time">
                                        {{ Carbon::parse($notif->created_at)->diffForHumans() }}
                                    </span>
                                </div>
                                <p class="notif-message mt-1">
                                    {{ $notif->message }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @empty
                <div class="empty-state">
                    <div class="text-5xl mb-3">📭</div>
                    <p class="text-lg">Belum ada notifikasi</p>
                    <p class="text-sm text-gray-500 mt-1">Notifikasi akan muncul di sini</p>
                </div>
            @endforelse

        </div>
    </div>

    {{-- MODAL DETAIL --}}
    <div id="detailModal" class="modal-overlay">
        <div class="modal-detail">
            <div class="modal-icon" id="modalIcon">🔔</div>
            <div class="modal-title" id="modalTitle"></div>
            <div class="modal-message" id="modalMessage"></div>
            <div class="modal-time" id="modalTime"></div>
            <button onclick="closeDetail()" class="btn-close">
                📋 Tutup
            </button>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let currentNotifId = null;

        function openDetail(element) {
            const id = element.dataset.id;
            const title = element.dataset.title;
            const message = element.dataset.message;
            const icon = element.dataset.icon;
            const time = element.dataset.time;
            const isRead = element.dataset.isread;

            currentNotifId = id;

            document.getElementById('modalIcon').textContent = icon;
            document.getElementById('modalTitle').textContent = title;
            document.getElementById('modalMessage').textContent = message;
            document.getElementById('modalTime').textContent = '📅 ' + time;

            document.getElementById('detailModal').classList.add('active');

            // Tandai dibaca kalau belum
            if (isRead === '0') {
                markAsRead(id);
                element.classList.remove('unread');
                element.classList.add('read');
                element.dataset.isread = '1';
                const badge = element.querySelector('.badge-unread');
                if (badge) badge.remove();
            }
        }

        function closeDetail() {
            document.getElementById('detailModal').classList.remove('active');
            currentNotifId = null;
            location.reload(); // Refresh untuk update status
        }

        function markAsRead(id) {
            fetch(`/notifications/${id}/read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            });
        }

        function markAllRead() {
            fetch(`/notifications/read-all`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            }).then(() => {
                location.reload();
            });
        }

        // Tutup modal dengan klik luar
        document.getElementById('detailModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDetail();
            }
        });
    </script>
@endpush
