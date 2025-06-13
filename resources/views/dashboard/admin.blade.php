@extends('layouts.base') {{-- Pastikan base menggunakan SB Admin --}}

@section('content')
<div class="container-fluid px-4 mt-4">
    <h1 class="mt-4">Dashboard Admin</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Selamat datang, <strong>{{ Auth::user()->name }}</strong>! Anda login sebagai <strong>Admin</strong>.</li>
    </ol>

    {{-- Card Statistik --}}
    <div class="row justify-content-center">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-info text-white shadow h-100 py-2 text-center">
                <div class="card-body">
                    <div class="text-white text-uppercase mb-1 fw-bold">Total Feedback</div>
                    <div class="h2 mb-0">{{ $totalFeedback }}</div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-success text-white shadow h-100 py-2 text-center">
                <div class="card-body">
                    <div class="text-white text-uppercase mb-1 fw-bold">Total Guru</div>
                    <div class="h2 mb-0">{{ $totalGuru }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Rata-rata Nilai --}}
    <div class="row justify-content-center">
        <div class="col-xl-8 col-md-10 mb-5">
            <div class="card shadow">
                <div class="card-header bg-primary text-white fw-bold">
                    Rata-rata Nilai Penilaian per Kriteria
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover mb-0">
                            <thead class="table-light">
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Kriteria</th>
                                    <th>Rata-rata Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($penilaian as $index => $item)
                                <tr class="text-center">
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->kriteria }}</td>
                                    <td>{{ number_format($item->rata_rata, 2) }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">Tidak ada data penilaian.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
