@extends('user.component.main')
@section('user_content')
    <header>
      @include('user.component.navbar')
    </header>
    <div class="page-banner">
        <h1>Visi & Misi</h1>
        <p>Arah dan Tujuan Strategis Perpustakaan AKPER HKBP</p>
    </div>

    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>Urutan</th>
                    <th>Poin Misi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($misi as $m)
                <tr>
                    <td>{{ $m->sequence }}</td>
                    <td>{{ $m->description }}</td>
                    <td>
                        <!-- Tombol Edit (Bisa diarahkan ke Modal) -->
                        <button onclick="editMisi({{ $m->id }}, '{{ $m->description }}', {{ $m->sequence }})">Edit</button>
                        
                        <!-- Tombol Hapus per Baris -->
                        <form action="{{ route('profile.delete', $m->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
  
    <footer>
      @include('user.component.footer')
    </footer>