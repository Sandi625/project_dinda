@extends('layouts.app')

@section('title', 'Detail Laporan Kinerja')

@section('content')
<div class="container mt-4">
    <h3>Detail Laporan Kinerja</h3>

    <div class="mb-3">
        <strong>Nama Guru:</strong> {{ $laporan->guru->nama }}
    </div>

    <div class="mb-3">
        <strong>Semester:</strong> {{ ucfirst($laporan->semester) }}
    </div>

    <div class="mb-4">
        <strong>Tanggal Dibuat:</strong> {{ $laporan->created_at->format('d-m-Y H:i') }}
    </div>

    <hr>

    <h5>Detail Kinerja</h5>
    @forelse ($laporan->detail as $index => $detail)
        <div class="card mb-3">
            <div class="card-body">
                <h6 class="card-title">Detail #{{ $index + 1 }}</h6>
                <p><strong>Kategori:</strong> {{ $detail->kategori }}</p>
                <p><strong>Indikator:</strong> {{ $detail->indikator }}</p>
                <p><strong>Keterangan:</strong> {{ $detail->keterangan ?? '-' }}</p>
                {{-- <p><strong>Poin:</strong> {{ $detail->poin ?? 'Belum dinilai' }}</p> --}}
                @if ($detail->file_bukti)
                    <p><strong>File Bukti:</strong>
                        <a href="{{ asset('storage/' . $detail->file_bukti) }}" target="_blank">Lihat File</a>
                    </p>
                @else
                    <p><strong>File Bukti:</strong> Tidak ada</p>
                @endif
            </div>
        </div>
    @empty
        <p class="text-muted">Belum ada detail laporan.</p>
    @endforelse

    <a href="{{ route('laporan_kinerja.index') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection
