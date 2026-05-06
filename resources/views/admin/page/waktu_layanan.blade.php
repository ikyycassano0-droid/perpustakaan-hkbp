@extends('admin.component.main')

@section('title', 'Manajemen Waktu Layanan')

@section('content')
<div class="max-w-7xl mx-auto">
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">🕒 Manajemen Waktu Layanan</h2>
            <p class="text-slate-500 text-sm mt-1">Kelola jadwal operasional dan layanan perpustakaan</p>
        </div>
        <button onclick="openCreateModal()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-sm transition flex items-center gap-2 w-fit">
            <i class="fas fa-plus-circle text-sm"></i>
            <span>Tambah Jadwal Baru</span>
        </button>
    </div>

    {{-- Success Alert --}}
    @if(session('success'))
    <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-3 rounded-xl flex items-center gap-3">
        <i class="fas fa-check-circle text-emerald-500"></i>
        <span class="text-sm">{{ session('success') }}</span>
        <button onclick="this.parentElement.remove()" class="ml-auto text-emerald-500 hover:text-emerald-700">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @endif

    {{-- Service Schedule Table --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">No</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Singkatan</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Hari</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Jam Layanan</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Warna</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Catatan</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Urutan</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Status Aktif</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-slate-600 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($schedules as $index => $schedule)
                    <tr class="hover:bg-slate-50 transition group" data-id="{{ $schedule->id }}">
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $index + 1 }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center justify-center w-10 h-10 bg-indigo-100 text-indigo-700 rounded-xl font-bold">
                                {{ $schedule->day_short }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-semibold text-slate-800 editable" data-field="day_name" data-id="{{ $schedule->id }}">{{ $schedule->day_name }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-mono text-slate-700 editable" data-field="service_hours" data-id="{{ $schedule->id }}">{{ $schedule->service_hours }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="editable-status" data-field="status" data-id="{{ $schedule->id }}">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium status-badge-{{ $schedule->id }}" style="background-color: {{ $schedule->status_color }}20; color: {{ $schedule->status_color }}">
                                    <span class="w-1.5 h-1.5 rounded-full" style="background-color: {{ $schedule->status_color }}"></span>
                                    {{ $schedule->status }}
                                </span>
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <select class="editable-select text-sm px-2 py-1 rounded-lg border border-slate-200 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100 outline-none transition" data-field="status_color" data-id="{{ $schedule->id }}" style="background-color: {{ $schedule->status_color }}20;">
                                <option value="#10b981" {{ $schedule->status_color == '#10b981' ? 'selected' : '' }} style="background-color: #10b98120;">🟢 Hijau</option>
                                <option value="#f59e0b" {{ $schedule->status_color == '#f59e0b' ? 'selected' : '' }} style="background-color: #f59e0b20;">🟡 Kuning</option>
                                <option value="#f97316" {{ $schedule->status_color == '#f97316' ? 'selected' : '' }} style="background-color: #f9731620;">🟠 Orange</option>
                                <option value="#f43f5e" {{ $schedule->status_color == '#f43f5e' ? 'selected' : '' }} style="background-color: #f43f5e20;">🔴 Merah</option>
                                <option value="#8b5cf6" {{ $schedule->status_color == '#8b5cf6' ? 'selected' : '' }} style="background-color: #8b5cf620;">🟣 Ungu</option>
                                <option value="#06b6d4" {{ $schedule->status_color == '#06b6d4' ? 'selected' : '' }} style="background-color: #06b6d420;">🔵 Biru</option>
                            </select>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-slate-500 editable" data-field="note" data-id="{{ $schedule->id }}">{{ $schedule->note ?? '-' }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-slate-600 editable-number" data-field="order" data-id="{{ $schedule->id }}">{{ $schedule->order }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full {{ $schedule->is_active ? 'bg-emerald-500' : 'bg-gray-400' }}"></span>
                                <span class="text-xs {{ $schedule->is_active ? 'text-emerald-600' : 'text-gray-500' }}">
                                    {{ $schedule->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <button onclick="openEditModal({{ json_encode($schedule) }})" class="text-indigo-600 hover:text-indigo-800 transition" title="Edit Lengkap">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button onclick="confirmDelete({{ $schedule->id }}, '{{ $schedule->day_name }}')" class="text-red-500 hover:text-red-700 transition" title="Hapus">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="px-6 py-12 text-center text-slate-500">
                            <i class="fas fa-calendar-day text-4xl mb-3 block text-slate-300"></i>
                            <p>Belum ada data jadwal layanan</p>
                            <button onclick="openCreateModal()" class="mt-3 text-indigo-600 hover:text-indigo-700 text-sm font-medium">
                                <i class="fas fa-plus"></i> Tambah jadwal pertama
                            </button>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ==================== MODAL CREATE ==================== --}}
<div id="createModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm">
    <div class="bg-white rounded-2xl w-full max-w-2xl mx-4 shadow-2xl max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between p-5 border-b border-slate-100 sticky top-0 bg-white">
            <h3 class="text-lg font-bold text-slate-800">📝 Tambah Jadwal Layanan</h3>
            <button onclick="closeCreateModal()" class="text-slate-400 hover:text-slate-600">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <form action="{{ route('admin.waktu_layanan.store') }}" method="POST" class="p-5">
            @csrf
            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Singkatan <span class="text-red-500">*</span></label>
                        <input type="text" name="day_short" required maxlength="5" placeholder="Sn" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100 outline-none transition">
                        <p class="text-xs text-slate-400 mt-1">Contoh: Sn, Sl, Rb, Km, Jm, Sb, Mg</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Nama Hari <span class="text-red-500">*</span></label>
                        <input type="text" name="day_name" required maxlength="20" placeholder="Senin" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100 outline-none transition">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Jam Layanan <span class="text-red-500">*</span></label>
                    <input type="text" name="service_hours" required placeholder="08:00 — 16:30" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100 outline-none transition">
                    <p class="text-xs text-slate-400 mt-1">Format: 08:00 — 16:30 atau 08:00 - 12:00 & 13:30 - 16:30</p>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Status <span class="text-red-500">*</span></label>
                        <input type="text" name="status" required placeholder="Layanan Penuh" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100 outline-none transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Warna Status <span class="text-red-500">*</span></label>
                        <select name="status_color" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100 outline-none">
                            <option value="#10b981">🟢 Hijau (Emerald)</option>
                            <option value="#f59e0b">🟡 Kuning (Amber)</option>
                            <option value="#f97316">🟠 Orange</option>
                            <option value="#f43f5e">🔴 Merah (Rose)</option>
                            <option value="#8b5cf6">🟣 Ungu</option>
                            <option value="#06b6d4">🔵 Biru</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Catatan (Opsional)</label>
                    <textarea name="note" rows="2" placeholder="Contoh: Sirkulasi Aktif, Layanan terbatas, dll" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100 outline-none transition"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Urutan <span class="text-red-500">*</span></label>
                    <input type="number" name="order" required min="0" value="0" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100 outline-none transition">
                    <p class="text-xs text-slate-400 mt-1">Semakin kecil angka, semakin atas tampilannya</p>
                </div>
                <div>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" checked class="w-4 h-4 text-indigo-600 rounded border-slate-300">
                        <span class="text-sm text-slate-700">Aktifkan jadwal ini</span>
                    </label>
                </div>
            </div>
            <div class="flex gap-3 mt-6 pt-3">
                <button type="button" onclick="closeCreateModal()" class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 transition">Batal</button>
                <button type="submit" class="flex-1 px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold transition shadow-sm">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- ==================== MODAL EDIT ==================== --}}
<div id="editModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm">
    <div class="bg-white rounded-2xl w-full max-w-2xl mx-4 shadow-2xl max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between p-5 border-b border-slate-100 sticky top-0 bg-white">
            <h3 class="text-lg font-bold text-slate-800">✏️ Edit Jadwal Layanan</h3>
            <button onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <form id="editForm" method="POST" class="p-5">
            @csrf
            @method('PUT')
            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Singkatan</label>
                        <input type="text" name="day_short" id="edit_day_short" required maxlength="5" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100 outline-none transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Nama Hari</label>
                        <input type="text" name="day_name" id="edit_day_name" required maxlength="20" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100 outline-none transition">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Jam Layanan</label>
                    <input type="text" name="service_hours" id="edit_service_hours" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100 outline-none transition">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                        <input type="text" name="status" id="edit_status" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100 outline-none transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Warna Status</label>
                        <select name="status_color" id="edit_status_color" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100 outline-none">
                            <option value="#10b981">🟢 Hijau (Emerald)</option>
                            <option value="#f59e0b">🟡 Kuning (Amber)</option>
                            <option value="#f97316">🟠 Orange</option>
                            <option value="#f43f5e">🔴 Merah (Rose)</option>
                            <option value="#8b5cf6">🟣 Ungu</option>
                            <option value="#06b6d4">🔵 Biru</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Catatan</label>
                    <textarea name="note" id="edit_note" rows="2" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100 outline-none transition"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Urutan</label>
                    <input type="number" name="order" id="edit_order" required min="0" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100 outline-none transition">
                </div>
                <div>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" id="edit_is_active" value="1" class="w-4 h-4 text-indigo-600 rounded border-slate-300">
                        <span class="text-sm text-slate-700">Aktifkan jadwal ini</span>
                    </label>
                </div>
            </div>
            <div class="flex gap-3 mt-6 pt-3">
                <button type="button" onclick="closeEditModal()" class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 transition">Batal</button>
                <button type="submit" class="flex-1 px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold transition shadow-sm">Update</button>
            </div>
        </form>
    </div>
</div>

{{-- Delete Form --}}
<form id="deleteForm" method="POST" action="" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('scripts')
<script>
    // ============================================
    // INLINE EDIT (AJAX) - updateField
    // ============================================
    
    // Untuk text editable
    document.querySelectorAll('.editable').forEach(element => {
        element.addEventListener('click', function() {
            const currentValue = this.innerText;
            const field = this.dataset.field;
            const id = this.dataset.id;
            
            // Buat input element
            const input = document.createElement('input');
            input.type = 'text';
            input.value = currentValue === '-' ? '' : currentValue;
            input.className = 'px-2 py-1 border border-indigo-300 rounded-lg text-sm w-full max-w-xs';
            
            const parent = this.parentElement;
            const originalText = this;
            
            // Replace dengan input
            parent.replaceChild(input, this);
            input.focus();
            
            // Save on blur
            input.addEventListener('blur', function() {
                const newValue = input.value;
                saveInlineEdit(id, field, newValue, originalText, parent);
            });
            
            // Save on enter
            input.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    const newValue = input.value;
                    saveInlineEdit(id, field, newValue, originalText, parent);
                }
            });
        });
    });
    
    // Untuk number editable
    document.querySelectorAll('.editable-number').forEach(element => {
        element.addEventListener('click', function() {
            const currentValue = this.innerText;
            const field = this.dataset.field;
            const id = this.dataset.id;
            
            const input = document.createElement('input');
            input.type = 'number';
            input.value = currentValue;
            input.className = 'px-2 py-1 border border-indigo-300 rounded-lg text-sm w-20 text-center';
            
            const parent = this.parentElement;
            const originalText = this;
            
            parent.replaceChild(input, this);
            input.focus();
            
            input.addEventListener('blur', function() {
                const newValue = input.value;
                saveInlineEdit(id, field, newValue, originalText, parent);
            });
            
            input.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    const newValue = input.value;
                    saveInlineEdit(id, field, newValue, originalText, parent);
                }
            });
        });
    });
    
    // Untuk select status color
    document.querySelectorAll('.editable-select').forEach(select => {
        select.addEventListener('change', function() {
            const id = this.dataset.id;
            const field = this.dataset.field;
            const newValue = this.value;
            
            // Update tampilan status badge
            const statusBadge = document.querySelector(`.status-badge-${id}`);
            if (statusBadge) {
                statusBadge.style.backgroundColor = newValue + '20';
                statusBadge.style.color = newValue;
                
                // Update dot warna
                const dot = statusBadge.querySelector('span');
                if (dot) {
                    dot.style.backgroundColor = newValue;
                }
            }
            
            saveInlineEdit(id, field, newValue, null, null);
        });
    });
    
    function saveInlineEdit(id, field, value, originalElement, parentElement) {
        // Show loading indicator
        const loadingSpan = document.createElement('span');
        loadingSpan.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        loadingSpan.className = 'text-indigo-500 text-sm';
        
        if (parentElement && originalElement) {
            parentElement.replaceChild(loadingSpan, originalElement);
        }
        
        fetch(`{{ route('admin.waktu_layanan.updateField', ['id' => '__ID__']) }}`.replace('__ID__', id), {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                field: field,
                value: value
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update tampilan
                if (originalElement && parentElement) {
                    if (field === 'note' && (value === '' || value === null)) {
                        originalElement.innerText = '-';
                    } else {
                        originalElement.innerText = value;
                    }
                    parentElement.replaceChild(originalElement, loadingSpan);
                }
                
                // Tampilkan notifikasi sukses
                showNotification('✅ ' + data.message, 'success');
            } else {
                throw new Error(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            if (originalElement && parentElement) {
                parentElement.replaceChild(originalElement, loadingSpan);
            }
            showNotification('❌ Gagal update data', 'error');
        });
    }
    
    // ============================================
    // NOTIFICATION SYSTEM
    // ============================================
    function showNotification(message, type = 'success') {
        // Hapus notifikasi lama jika ada
        const oldNotif = document.querySelector('.custom-notification');
        if (oldNotif) oldNotif.remove();
        
        const notification = document.createElement('div');
        notification.className = 'custom-notification fixed bottom-5 right-5 z-50 px-5 py-3 rounded-xl shadow-lg transition-all transform translate-x-0 ' + 
            (type === 'success' ? 'bg-emerald-500 text-white' : 'bg-red-500 text-white');
        notification.innerHTML = message;
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.opacity = '0';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }
    
    // ============================================
    // MODAL HANDLERS
    // ============================================
    function openCreateModal() {
        document.getElementById('createModal').classList.remove('hidden');
        document.getElementById('createModal').classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeCreateModal() {
        document.getElementById('createModal').classList.add('hidden');
        document.getElementById('createModal').classList.remove('flex');
        document.body.style.overflow = '';
    }

    function openEditModal(data) {
        document.getElementById('edit_day_short').value = data.day_short;
        document.getElementById('edit_day_name').value = data.day_name;
        document.getElementById('edit_service_hours').value = data.service_hours;
        document.getElementById('edit_status').value = data.status;
        document.getElementById('edit_status_color').value = data.status_color;
        document.getElementById('edit_note').value = data.note || '';
        document.getElementById('edit_order').value = data.order;
        document.getElementById('edit_is_active').checked = data.is_active === 1;
        
        const form = document.getElementById('editForm');
        form.action = "{{ route('admin.waktu_layanan.update', ['id' => '__ID__']) }}".replace('__ID__', data.id);
        
        document.getElementById('editModal').classList.remove('hidden');
        document.getElementById('editModal').classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
        document.getElementById('editModal').classList.remove('flex');
        document.body.style.overflow = '';
    }

    function confirmDelete(id, name) {
        if (confirm(`Hapus jadwal untuk hari "${name}"? Data akan dihapus secara permanen.`)) {
            const form = document.getElementById('deleteForm');
            form.action = "{{ route('admin.waktu_layanan.destroy', ['id' => '__ID__']) }}".replace('__ID__', id);
            form.submit();
        }
    }

    // Close modal on outside click
    window.onclick = function(event) {
        const createModal = document.getElementById('createModal');
        const editModal = document.getElementById('editModal');
        if (event.target === createModal) closeCreateModal();
        if (event.target === editModal) closeEditModal();
    }
</script>
@endpush