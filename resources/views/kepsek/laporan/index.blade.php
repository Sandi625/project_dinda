@extends('layouts.master')

@section('content')
<div class="container mt-4">
    <h4 class="mb-4">📊 Laporan Pembelajaran - Kepala Sekolah</h4>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Bulan</th>
                    <th>Guru</th>
                    <th>Kelas</th>
                    <th>Mapel</th>
                    <th>Pertemuan</th>
                    <th>Kehadiran</th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($laporanList as $laporan)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $laporan->bulan }}</td>
                        <td>{{ $laporan->guru->nama ?? '-' }}</td>
                      <td>{{ $laporan->kelas->nama_kelas ?? '-' }}</td>
                        <td>{{ $laporan->mapel->nama_mapel ?? '-' }}</td>
                        <td>{{ $laporan->jumlah_pertemuan }}</td>
                        <td>{{ $laporan->rata_kehadiran }}%</td>
                        <td>
                            <a href="{{ route('kepsek.laporan.show', $laporan->id_laporan) }}" class="btn btn-sm btn-info">🔍 Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">Belum ada laporan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
