@extends('admin.component.main')

@section('title', 'Manajemen Anggota')
@section('page-title', 'Data Anggota')

@section('admin_content')

<div class="table-card">
    <div class="table-header">
        <h5>Daftar Anggota</h5>
        <a href="{{ route('admin.members.create') }}" class="btn btn-primary-custom">
            <i class="fas fa-plus"></i> Tambah Anggota
        </a>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>NPM</th>
                <th>No HP</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($members as $member)
            <tr>
                <td>{{ $member->name }}</td>
                <td>{{ $member->npm }}</td>
                <td>{{ $member->phone }}</td>
                <td>
                    <span class="badge-status {{ $member->active ? 'badge-active' : 'badge-pending' }}">
                        {{ $member->active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection