@extends('layouts.master')

@section('title', 'Daftar Penilaian Guru')

@section('content')
<div class="container mt-4">
    <h1>Daftar Penilaian Guru</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <a href="{{ route('kepsek.create') }}" class="btn btn-primary mb-3">Tambah Penilaian</a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Guru</th>
                <th>Periode</th>
                <th>Tanggal</th>
                <th>Detail Nilai</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($penilaian as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->guru->nama ?? '-' }}</td>
                <td>{{ $item->periode }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                <td>
                    <ul class="mb-0">
                        @foreach($item->detailPenilaian as $detail)
                            <li>{{ $detail->kriteria->nama ?? 'Kriteria tidak ditemukan' }}: {{ $detail->nilai }}</li>
                        @endforeach
                    </ul>
                </td>
                <td>
                    <a href="{{ route('kepsek.edit', $item->id_penilaian) }}" class="btn btn-warning btn-sm">Edit</a>

                    <form action="{{ route('kepsek.destroy', $item->id_penilaian) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Yakin ingin menghapus penilaian ini?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Belum ada data penilaian.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
