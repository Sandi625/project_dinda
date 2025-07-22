@extends('layouts.app')

@section('title', 'Laporan Pembelajaran')

@section('content')
<div class="container mt-4">
    <h4 class="mb-4">📄 Daftar Laporan Pembelajaran</h4>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-3">
        <a href="{{ route('laporan.create') }}" class="btn btn-primary">➕ Tambah Laporan</a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Bulan</th>
                    <th>Kelas</th>
                    <th>Mata Pelajaran</th>
                    <th>Jumlah Pertemuan</th>
                    <th>Kehadiran</th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($laporanList as $laporan)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $laporan->bulan }}</td>
                        <td>{{ $laporan->kelas->nama_kelas ?? '-' }}</td>
                        <td>{{ $laporan->mapel->nama_mapel ?? '-' }}</td>
                        <td>{{ $laporan->jumlah_pertemuan }}</td>
                        <td>{{ $laporan->rata_kehadiran }}%</td>
                        <td>
                            <a href="{{ route('laporan.show', $laporan->id_laporan) }}" class="btn btn-sm btn-info">👁 Detail</a>

                            <a href="{{ route('laporan.edit', $laporan->id_laporan) }}" class="btn btn-sm btn-warning">✏️ Edit</a>
                            <form action="{{ route('laporan.destroy', $laporan->id_laporan) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus laporan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">🗑 Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">Belum ada laporan pembelajaran.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

