@extends('user.component.main')

<header>
    @include('user.component.navbar')
</header>

@section('title', 'Pencarian')

@section('user_content')

<div class="container py-4">

    <h3 class="mb-3">🔍 Pencarian Koleksi</h3>

    {{-- SEARCH BAR --}}
    <div style="position: relative; max-width: 600px;">
        <input 
            type="text" 
            id="liveSearch"
            class="form-control"
            placeholder="Cari buku, jurnal, skripsi..."
            autocomplete="off"
        >

        {{-- RESULT BOX --}}
        <div id="searchResultBox" 
             class="list-group shadow"
             style="position:absolute; width:100%; z-index:999;"></div>
    </div>

</div>

@endsection

{{-- ================= STYLE ================= --}}
@section('styles')
<style>
#searchResultBox {
    max-height: 400px;
    overflow-y: auto;
    border-radius: 10px;
}

.list-group-item:hover {
    transform: scale(1.02);
    transition: 0.2s;
}
</style>
@endsection

{{-- ================= SCRIPT ================= --}}
@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
const input = document.getElementById('liveSearch');
const resultBox = document.getElementById('searchResultBox');

let timeout = null;

// ================= LIVE SEARCH =================
input.addEventListener('keyup', function() {

    clearTimeout(timeout);

    let keyword = this.value;

    if(keyword.length < 2){
        resultBox.innerHTML = '';
        return;
    }

    timeout = setTimeout(() => {

        fetch(`/user/live-search?keyword=${keyword}`)
            .then(res => res.json())
            .then(data => {

                let html = '';

                if(data.length === 0){
                    html = `<div class="list-group-item">Tidak ditemukan</div>`;
                }

                data.forEach(item => {

                    html += `
                        <a href="#"
                           class="list-group-item list-group-item-action live-item d-flex justify-content-between align-items-center"
                           data-id="${item.id}"
                           data-type="${item.type}"
                           data-file="${item.file_url ?? ''}">
                           
                           <span>${item.title}</span>

                           ${
                                item.type === 'collection'
                                ? '<span class="badge bg-primary">📚</span>'
                                : '<span class="badge bg-success">🎓</span>'
                           }
                        </a>
                    `;
                });

                resultBox.innerHTML = html;

            });

    }, 300);

});


// ================= CLICK HANDLER =================
document.addEventListener('click', function(e){

    const item = e.target.closest('.live-item');
    if(!item) return;

    e.preventDefault();

    const id = item.dataset.id;
    const type = item.dataset.type;
    const file = item.dataset.file;

    const isGuest = {{ auth()->check() ? 'false' : 'true' }};

    // 🔒 KOLEKSI TERCETAK WAJIB LOGIN
    if(isGuest && type === 'collection'){
        Swal.fire({
            title: 'Login Diperlukan',
            text: 'Silakan login untuk mengakses koleksi tercetak',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Login',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if(result.isConfirmed){
                window.location.href = "{{ route('login') }}";
            }
        });
        return;
    }

    // 🚀 REDIRECT
    if(type === 'collection'){
        window.location.href = `/collections/${id}`;
    } else {
        window.open(`/storage/${file}`, '_blank');
    }

});


// ================= TUTUP RESULT KALAU KLIK LUAR =================
document.addEventListener('click', function(e){
    if(!e.target.closest('#liveSearch')){
        resultBox.innerHTML = '';
    }
});
</script>

@endsection