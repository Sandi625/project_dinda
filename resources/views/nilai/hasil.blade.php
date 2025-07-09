@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Hasil Nilai Siswa</h3>

    <p><strong>Kelas:</strong> {{ $kelas->nama_kelas }} | <strong>Mapel:</strong> {{ $mapel->nama_mapel }}</p>

    <table class="table table-bordered table-striped">
        <thead class="table-light">
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>NIS</th>
                <th>Nilai</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($siswa as $index => $s)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $s->nama }}</td>
                    <td>{{ $s->nis }}</td>
                    <td>{{ $s->nilai ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Tidak ada siswa ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Tampilkan rata-rata jika ada data --}}
    @if($siswa->count())
        @php
            $rataRata = $siswa->whereNotNull('nilai')->avg('nilai');
        @endphp
        <div class="alert alert-info">
            <strong>Rata-Rata Nilai:</strong> {{ number_format($rataRata, 2) }}
        </div>
    @endif

    <a href="{{ route('beri-nilai.lihat') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection

