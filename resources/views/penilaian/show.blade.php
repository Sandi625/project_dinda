@extends('layouts.base')

@section('content')
<div class="container mt-4">
    <h2>Detail Penilaian</h2>

    <div class="card">
        <div class="card-header">
            Data Penilaian
        </div>
        <div class="card-body">
            <p><strong>Guru:</strong> {{ $penilaian->guru->nama ?? 'Guru tidak ditemukan' }}</p>
            <p><strong>Periode:</strong> {{ $penilaian->periode }}</p>
            <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($penilaian->tanggal)->format('d-m-Y') }}</p>

            <hr>

            <h5>Kriteria & Nilai:</h5>
            <ul>
                @foreach ($penilaian->detailPenilaian as $detail)
                    <li>
                        <strong>{{ $detail->kriteria->nama ?? 'Kriteria tidak ditemukan' }}</strong>:
                        {{ $detail->nilai }}
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <a href="{{ route('penilaian.index') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection
