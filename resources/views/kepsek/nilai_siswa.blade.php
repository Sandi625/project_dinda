@extends('layouts.master')

@section('content')
<div class="container">
    <h4 class="mb-4">Rekap Nilai Siswa</h4>

    @foreach($data as $siswa)
        <div class="card mb-4">
            <div class="card-header bg-dark text-white">
                <strong>{{ $siswa['nama_siswa'] }}</strong> ({{ $siswa['kelas'] }}) -
                Rata-rata: <span class="text-warning">{{ $siswa['rata_rata'] }}</span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Mata Pelajaran</th>
                                <th>Kriteria</th>
                                <th>Semester</th>
                                <th>Nilai</th>
                                <th>Tanggal</th>
                                <th>Guru Penilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($siswa['nilai_detail'] as $n)
                                <tr>
                                    <td>{{ $n->mapel }}</td>
                                    <td>{{ $n->kriteria }}</td>
                                    <td>{{ ucfirst($n->semester) }}</td>
                                    <td><strong>{{ $n->nilai }}</strong></td>
                                    <td>{{ \Carbon\Carbon::parse($n->tanggal)->format('d M Y') }}</td>
                                    <td>{{ $n->nama_guru ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
