@extends('layouts.base')

@section('content')
<div class="container">
    <h2>Data Jadwal Mengajar</h2>
    <a href="{{ route('jadwal-mengajar.create') }}" class="btn btn-primary mb-3">Tambah Jadwal</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Guru</th>
                <th>Mapel</th>
                <th>Kelas</th>
                <th>Hari</th>
                <th>Jam</th>
                <th>Aksi</th>
            </tr>
        </thead>
    <tbody>
    @forelse ($jadwal as $item)
        <tr>
            <td>{{ $item->guru->nama ?? '-' }}</td>
            <td>{{ $item->mapel->nama_mapel ?? '-' }}</td>
            <td>{{ $item->kelas->nama_kelas ?? '-' }}</td>
            <td>{{ $item->hari }}</td>
            <td>
                {{ \Carbon\Carbon::parse($item->jam_mulai)->format('H:i') }} -
                {{ \Carbon\Carbon::parse($item->jam_selesai)->format('H:i') }} WIB
            </td>
            <td>
                <a href="{{ route('jadwal-mengajar.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('jadwal-mengajar.destroy', $item->id) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button onclick="return confirm('Yakin ingin menghapus?')" class="btn btn-danger btn-sm">Hapus</button>
                </form>
            </td>
        </tr>
    @empty
        <tr><td colspan="6" class="text-center">Tidak ada data</td></tr>
    @endforelse
</tbody>

    </table>
</div>
@endsection
