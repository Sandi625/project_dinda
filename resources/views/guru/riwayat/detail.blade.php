@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Detail Penilaian</h4>

    <div class="mb-4">
        <table class="table table-bordered">
            <tr>
                <th>Tanggal</th>
                <td>{{ $penilaian->tanggal->format('d-m-Y') }}</td>
            </tr>
            <tr>
                <th>Periode</th>
                <td>{{ $penilaian->periode }}</td>
            </tr>
            <tr>
                <th>Kelas</th>
                <td>{{ $penilaian->kelas->nama_kelas ?? '-' }}</td>
            </tr>
            <tr>
                <th>Mata Pelajaran</th>
                <td>{{ $penilaian->mapel->nama_mapel ?? '-' }}</td>
            </tr>
            <tr>
                <th>Dinilai Oleh</th>
                <td>{{ $penilaian->user->name ?? '-' }}</td>
            </tr>
        </table>
    </div>

    <h5>Detail Nilai</h5>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Kriteria</th>
                <th>Nilai</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($penilaian->detailPenilaian as $index => $detail)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $detail->kriteria->nama_kriteria ?? '-' }}</td>
                    <td>{{ $detail->nilai }}</td>
                    <td>{{ $detail->catatan ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Belum ada detail penilaian</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <a href="{{ route('guru.riwayat') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection
