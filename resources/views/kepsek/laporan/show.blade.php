@extends('layouts.master')

@section('content')
<div class="container mt-4">
    <h4 class="mb-4">📄 Detail Laporan Pembelajaran</h4>

    <a href="{{ route('kepsek.laporan.index') }}" class="btn btn-secondary mb-3">⬅️ Kembali</a>

    <div class="card">
        <div class="card-body">
            <p><strong>Bulan:</strong> {{ $laporan->bulan }}</p>
            <p><strong>Guru:</strong> {{ $laporan->guru->nama ?? '-' }}</p>
            <p><strong>Kelas:</strong> {{ $laporan->kelas->nama_kelas ?? '-' }}</p>
            <p><strong>Mapel:</strong> {{ $laporan->mapel->nama_mapel ?? '-' }}</p>
            <p><strong>Jumlah Pertemuan:</strong> {{ $laporan->jumlah_pertemuan }}</p>
            <p><strong>Rata Kehadiran:</strong> {{ $laporan->rata_kehadiran }}%</p>
            <p><strong>Materi:</strong> {{ $laporan->materi }}</p>
            <p><strong>Metode:</strong> {{ $laporan->metode }}</p>
            <p><strong>Evaluasi:</strong> {{ $laporan->evaluasi }}</p>
            <p><strong>Kendala:</strong> {{ $laporan->kendala }}</p>
            <p><strong>Solusi:</strong> {{ $laporan->solusi }}</p>
            <p><strong>Catatan:</strong> {{ $laporan->catatan }}</p>
        </div>
    </div>
</div>
@endsection
