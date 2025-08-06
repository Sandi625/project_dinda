@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Daftar Penilaian</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <a href="{{ route('penilaian.pdf') }}" class="btn btn-danger mb-3">Export PDF</a>

    {{-- Filter berdasarkan Semester --}}
    <form method="GET" action="{{ route('guru.riwayat') }}" class="mb-3 d-flex align-items-center gap-2">
        <label for="id_semester" class="form-label mb-0">Filter Semester:</label>
        <select name="id_semester" id="id_semester" class="form-select w-auto d-inline-block" onchange="this.form.submit()">
            <option value="">-- Semua --</option>
            @foreach ($daftarSemester as $semesterOption)
                <option value="{{ $semesterOption->id }}" {{ request('id_semester') == $semesterOption->id ? 'selected' : '' }}>
                    {{ ucfirst($semesterOption->semester) }} - {{ $semesterOption->tahun }}
                </option>
            @endforeach
        </select>
    </form>

    <table class="table table-bordered table-striped align-middle">
        <thead class="table-success">
            <tr>
                <th>#</th>
                <th>Nama User</th>
                <th>Kelas</th>
                <th>Mapel</th>
                <th>Semester</th>
                <th>Tanggal</th>
                <th>Kriteria & Nilai</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($penilaian as $p)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $p->guru->name ?? 'User tidak ditemukan' }}</td>
                <td>{{ $p->kelas->nama_kelas ?? '-' }}</td>
                <td>{{ $p->mapel->nama_mapel ?? '-' }}</td>
                <td>
                    {{ ucfirst($p->semester->semester ?? '-') }} - {{ $p->semester->tahun ?? '-' }}
                </td>
                <td>{{ \Carbon\Carbon::parse($p->tanggal)->format('d-m-Y') }}</td>
                <td>
                    <ul class="mb-0 ps-3">
                        @foreach ($p->detailPenilaian as $detail)
                            <li>
                                {{ $detail->kriteria->nama ?? 'Kriteria tidak ditemukan' }}:
                                {{ $detail->nilai }}
                            </li>
                        @endforeach
                    </ul>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Belum ada data penilaian.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
