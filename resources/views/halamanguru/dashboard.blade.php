@extends('layouts.app') {{-- Ganti dengan layout utama kamu --}}

@section('title', 'Dashboard Guru')

@section('content')
<div class="container mt-4">
    <h1>Selamat datang, {{ $guru->name ?? 'Guru' }}!</h1>

    <div class="row mt-4">
        {{-- Statistik --}}
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Total Penilaian</div>
                <div class="card-body">
                    <h3 class="card-title">{{ $totalPenilaian }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Total Feedback</div>
                <div class="card-body">
                    <h3 class="card-title">{{ $totalFeedback }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Penilaian Terbaru --}}
    <div class="card mt-4">
        <div class="card-header">
            <h4>Penilaian Terbaru</h4>
        </div>
        <div class="card-body">
            @if($penilaianTerbaru->isEmpty())
                <p>Tidak ada data penilaian.</p>
            @else
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID Penilaian</th>
                            <th>Kriteria</th>
                            <th>Feedback</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($penilaianTerbaru as $penilaian)
                        <tr>
                            <td>{{ $penilaian->id_penilaian ?? $penilaian->id }}</td>
                            <td>
                                @foreach($penilaian->detailPenilaian as $detail)
                                    <span class="badge bg-info text-dark">{{ $detail->kriteria->nama ?? '-' }}</span>
                                @endforeach
                            </td>
                            <td>
                                @if($penilaian->feedback)
                                    {{ Str::limit($penilaian->feedback->isi, 50) }}
                                @else
                                    <em>Belum ada feedback</em>
                                @endif
                            </td>
                            <td>{{ $penilaian->created_at->format('d M Y') ?? '-' }}</td>
                            <td>
                                <a href="{{ route('halamanguru.show', $penilaian->id_penilaian ?? $penilaian->id) }}" class="btn btn-sm btn-primary">Detail</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection
