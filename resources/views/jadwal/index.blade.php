@extends('layouts.base')

@section('content')
<div class="container">
    <h2>Data Jadwal Mengajar</h2>

    <a href="{{ route('jadwal.create') }}" class="btn btn-primary mb-3">Tambah Jadwal</a>
    <a href="{{ route('jadwal.export') }}" class="btn btn-success mb-3">Export Excel</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
@php
    $jamMapping = [
        1 => '07:00 - 07:45',
        2 => '07:45 - 08:30',
        3 => '08:30 - 09:15',
        4 => '09:15 - 10:00',
        5 => '10:20 - 11:05',
        6 => '11:05 - 11:50',
        7 => '12:30 - 13:10',
        8 => '13:10 - 13:50',
        9 => '13:50 - 14:30',
        10 => '14:30 - 15:10',
    ];
@endphp

<table class="table table-bordered table-striped">
    <thead class="table-light">
        <tr>

            <th>Guru</th>
            <th>Mapel</th>
            <th>Kelas</th>
                    <th>Akun</th> {{-- Tambahan --}}

            <th>Hari</th>
            <th>Jam Ke</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
    @forelse ($jadwals as $item)
        <tr>
            <td>{{ $item->guru->nama ?? '-' }}</td>
            <td>{{ $item->mapel->nama_mapel ?? '-' }}</td>
            <td>{{ $item->kelas->nama_kelas ?? '-' }}</td>
                    <td>{{ $item->user->name ?? '-' }}</td> {{-- Tambahan --}}

            <td>{{ $item->hari }}</td>
            <td>
                Jam ke-{{ $item->jam_ke }}
                ({{ $jamMapping[$item->jam_ke] ?? 'Tidak diketahui' }})
            </td>
    <td>
    <a href="{{ route('jadwal.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
    <form action="{{ route('jadwal.destroy', $item->id) }}" method="POST" style="display:inline;">
        @csrf @method('DELETE')
        <button onclick="return confirm('Yakin ingin menghapus?')" class="btn btn-danger btn-sm">Hapus</button>
    </form>
    <a href="{{ route('jadwal.export.single', $item->id) }}" class="btn btn-success btn-sm mt-1">Export Excel</a>
</td>


        </tr>
    @empty
        <tr>
            <td colspan="6" class="text-center">Tidak ada data</td>
        </tr>
    @endforelse
    </tbody>
</table>

</div>
@endsection
