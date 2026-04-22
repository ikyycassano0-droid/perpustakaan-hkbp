@extends('admin.component.main')

@section('title', 'Manajemen Anggota')
@section('page-title', 'Data Anggota')

@section('admin_content')

<div class="table-card">

    <!-- HEADER -->
    <div class="table-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Anggota</h5>

        <a href="{{ route('admin.members.create') }}" class="btn btn-primary-custom">
            <i class="fas fa-plus"></i> Tambah Anggota
        </a>
    </div>

    <!-- TABLE -->
    <div class="table-responsive">
        <table class="table align-middle">

            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Role</th>
                    <th>NPM / NIDN</th>
                    <th>No HP</th>
                    <th>Status Akun</th>
                    <th>Status Email</th>
                    <th width="150">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($members as $member)
                <tr>

                    <!-- NAMA -->
                    <td class="fw-semibold">
                        {{ $member->name }}
                    </td>

                    <!-- ROLE -->
                    <td>
                        <span class="badge 
                            @if(optional($member->role)->name == 'Admin') bg-danger
                            @elseif(optional($member->role)->name == 'Dosen') bg-info
                            @else bg-secondary
                            @endif
                        ">
                            {{ optional($member->role)->name ?? '-' }}
                        </span>
                    </td>

                    <!-- NPM / NIDN -->
                    <td>
                        {{ $member->npm ?? $member->nidn ?? '-' }}
                    </td>

                    <!-- PHONE -->
                    <td>
                        {{ $member->phone ?? '-' }}
                    </td>

                    <!-- STATUS AKUN -->
                    <td>
                        <span class="badge-status {{ $member->active ? 'badge-active' : 'badge-pending' }}">
                            {{ $member->active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>

                    <!-- 🔥 STATUS EMAIL -->
                    <td>
                        @if($member->email_verified_at)
                            <span class="badge bg-success">Verified</span>
                        @else
                            <span class="badge bg-warning text-dark">Belum Verifikasi</span>
                        @endif
                    </td>

                    <!-- ACTION -->
                    <td>

                        <!-- EDIT -->
                        <a href="{{ route('admin.members.edit', $member->id) }}"
                           class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i>
                        </a>

                        <!-- DELETE -->
                        <form action="{{ route('admin.members.destroy.post', $member->id) }}"
                              method="POST"
                              class="d-inline"
                              onsubmit="return confirm('Yakin ingin menghapus anggota ini?')">

                            @csrf
                            @method('DELETE')

                            <button class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i>
                            </button>

                        </form>

                    </td>

                </tr>
                @empty

                <tr>
                    <td colspan="7" class="text-center text-muted py-4">
                        Tidak ada data anggota
                    </td>
                </tr>

                @endforelse
            </tbody>

        </table>
    </div>
</div>

@endsection
