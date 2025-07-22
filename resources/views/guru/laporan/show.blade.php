@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">📄 Detail Laporan Pembelajaran</h3>

    <a href="{{ route('laporan.index') }}" class="btn btn-secondary mb-3">⬅️ Kembali ke Daftar</a>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>Bulan</th>
                    <td>{{ $laporan->bulan }}</td>
                </tr>
                <tr>
                    <th>Kelas</th>
                    <td>{{ $laporan->kelas->nama_kelas ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Mata Pelajaran</th>
                    <td>{{ $laporan->mapel->nama_mapel ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Jumlah Pertemuan</th>
                    <td>{{ $laporan->jumlah_pertemuan ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Rata-rata Kehadiran</th>
                    <td>{{ $laporan->rata_kehadiran ?? '-' }}%</td>
                </tr>
                <tr>
                    <th>Materi</th>
                    <td>{{ $laporan->materi ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Metode</th>
                    <td>{{ $laporan->metode ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Evaluasi</th>
                    <td>{{ $laporan->evaluasi ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Kendala</th>
                    <td>{{ $laporan->kendala ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Solusi</th>
                    <td>{{ $laporan->solusi ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Catatan</th>
                    <td>{{ $laporan->catatan ?? '-' }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection
