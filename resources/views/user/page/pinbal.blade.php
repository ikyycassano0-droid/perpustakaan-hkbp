@extends('user.component.main')

@section('title', 'Pinjam Buku')

@section('content')
<div class="container py-4">

    <h2 class="mb-4 fw-bold">📚 Pinjam Buku</h2>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger shadow-sm">{{ session('error') }}</div>
    @endif

    <div class="row">
        @foreach($collections as $item)
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm border-0 hover-card">

                {{-- COVER --}}
                <div class="position-relative">
                    @if($item->cover_image)
                        <img src="{{ asset('storage/'.$item->cover_image) }}" class="card-img-top rounded-top" height="200">
                    @else
                        <img src="https://via.placeholder.com/300x200?text=No+Image" class="card-img-top">
                    @endif

                    {{-- STOCK --}}
                    <span class="badge bg-dark position-absolute top-0 end-0 m-2">
                        Stok: {{ $item->stock }}
                    </span>
                </div>

                <div class="card-body d-flex flex-column">

                    <h5 class="fw-bold">{{ $item->title }}</h5>

                    {{-- ================= USER LOGIN ================= --}}
                    @auth
                    <form action="{{ route('orders.store') }}" method="POST" onsubmit="return validateDates(this)">
                        @csrf

                        <input type="hidden" name="collection_id" value="{{ $item->id }}">

                        <div class="mb-2">
                            <label class="small">Tanggal Pinjam</label>
                            <input type="date" name="order_date" class="form-control"
                                   onchange="autoReturn(this)" required>
                        </div>

                        <div class="mb-2">
                            <label class="small">Tanggal Kembali</label>
                            <input type="date" name="return_date" class="form-control"
                                   onchange="hitungHari(this)" required>
                        </div>

                        {{-- INFO --}}
                        <small class="text-muted sisa-hari d-block">Durasi: -</small>
                        <small class="text-success info-denda d-block">-</small>

                        @if($item->stock > 0)
                            <button class="btn btn-primary w-100 mt-2 btn-hover">
                                Pinjam
                            </button>
                        @else
                            <button class="btn btn-secondary w-100 mt-2" disabled>
                                Stok Habis
                            </button>
                        @endif
                    </form>
                    @endauth

                    {{-- ================= GUEST ================= --}}
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-warning mt-auto">
                            Login untuk Pinjam
                        </a>
                    @endguest

                </div>
            </div>
        </div>
        @endforeach
    </div>

</div>

{{-- ================= STYLE ================= --}}
<style>
.hover-card {
    transition: 0.3s;
}
.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}
.btn-hover:hover {
    transform: scale(1.03);
}
.border-danger {
    border: 2px solid red !important;
}
.border-warning {
    border: 2px solid orange !important;
}
</style>

{{-- ================= SCRIPT ================= --}}
<script>

// set minimal tanggal hari ini
document.querySelectorAll('input[name="order_date"]').forEach(el => {
    let today = new Date().toISOString().split('T')[0];
    el.setAttribute('min', today);
});

// auto isi tanggal kembali + batas max
function autoReturn(input) {
    let orderDate = new Date(input.value);
    let form = input.closest('form');
    let returnInput = form.querySelector('input[name="return_date"]');

    let returnDate = new Date(orderDate);
    returnDate.setDate(returnDate.getDate() + 7);

    let maxDate = new Date(orderDate);
    maxDate.setDate(maxDate.getDate() + 14);

    returnInput.value = returnDate.toISOString().split('T')[0];
    returnInput.setAttribute('min', input.value);
    returnInput.setAttribute('max', maxDate.toISOString().split('T')[0]);

    updateInfo(form);
}

// update info durasi + denda
function updateInfo(form) {
    let orderDate = new Date(form.order_date.value);
    let returnDate = new Date(form.return_date.value);

    let infoHari = form.querySelector('.sisa-hari');
    let infoDenda = form.querySelector('.info-denda');
    let returnInput = form.querySelector('input[name="return_date"]');

    if (form.order_date.value && form.return_date.value) {

        let diff = (returnDate - orderDate) / (1000 * 60 * 60 * 24);

        returnInput.classList.remove('border-danger', 'border-warning');

        if (diff <= 0) {
            infoHari.innerHTML = "<span style='color:red'>Tanggal tidak valid</span>";
            returnInput.classList.add('border-danger');
            return false;
        }

        if (diff > 14) {
            infoHari.innerHTML = "<span style='color:red'>❌ Maksimal 14 hari!</span>";
            returnInput.classList.add('border-danger');
            return false;
        }

        infoHari.innerHTML = "Durasi: <b>" + diff + " hari</b>";

        if (diff > 10) {
            infoHari.innerHTML += " ⚠️ <span style='color:orange'>Mendekati batas</span>";
            returnInput.classList.add('border-warning');
        }

        // simulasi denda
        let lateDays = diff - 14;

        if (lateDays > 0) {
            let denda = 0;

            if (lateDays <= 3) {
                denda = lateDays * 1000;
            } else if (lateDays <= 7) {
                denda = lateDays * 2000;
            } else {
                denda = lateDays * 5000;
            }

            infoDenda.innerHTML = "💸 Rp " + denda.toLocaleString();
        } else {
            infoDenda.innerHTML = "✅ Aman";
        }
    }
}

// trigger onchange
function hitungHari(input) {
    let form = input.closest('form');
    updateInfo(form);
}

// validasi submit
function validateDates(form) {
    let orderDate = new Date(form.order_date.value);
    let returnDate = new Date(form.return_date.value);

    let diff = (returnDate - orderDate) / (1000 * 60 * 60 * 24);

    if (returnDate <= orderDate) {
        alert("Tanggal kembali tidak valid!");
        return false;
    }

    if (diff > 14) {
        alert("Tidak boleh lebih dari 14 hari!");
        return false;
    }

    return confirm("Yakin ingin meminjam buku ini?");
}

</script>

@endsection