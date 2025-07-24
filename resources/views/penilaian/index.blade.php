@extends('layouts.base')

@section('content')
<div class="container mt-4">
    <h2>Daftar Penilaian</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <a href="{{ route('penilaian.create') }}" class="btn btn-primary mb-3">Tambah Penilaian</a>
    <a href="{{ route('penilaian.pdf') }}" class="btn btn-danger mb-3">Export PDF</a>

    <form method="GET" action="{{ route('penilaian.index') }}" class="mb-3 d-flex align-items-center gap-2">
        <label for="semester" class="form-label mb-0">Filter Semester:</label>
        <select name="semester" id="semester" class="form-select w-auto d-inline-block" onchange="this.form.submit()">
            <option value="">-- Semua --</option>
            @foreach ($daftarSemester as $semesterOption)
                <option value="{{ $semesterOption }}" {{ request('semester') == $semesterOption ? 'selected' : '' }}>
                    {{ ucfirst($semesterOption) }}
                </option>
            @endforeach
        </select>
    </form>

    <table class="table table-bordered table-striped align-middle">
        <thead class="table-white">
            <tr>
                <th>#</th>
                <th>Guru</th>
                <th>Kelas</th>
                <th>Mapel</th>
                <th>Semester</th>
                <th>Tanggal</th>
                <th>Kriteria & Nilai</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($penilaian as $p)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $p->guru->nama ?? 'Guru tidak ditemukan' }}</td>
                <td>{{ $p->kelas->nama_kelas ?? '-' }}</td>
                <td>{{ $p->mapel->nama_mapel ?? '-' }}</td>
                <td>{{ ucfirst($p->guru->semester ?? '-') }}</td>
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
                <td>
                    <a href="{{ route('penilaian.download', $p->id_penilaian) }}" class="btn btn-sm btn-info">Download</a>
                    <a href="{{ route('penilaian.edit', $p->id_penilaian) }}" class="btn btn-sm btn-warning">Edit</a>

                    <form action="{{ route('penilaian.destroy', $p->id_penilaian) }}" method="POST" class="d-inline"
                        onsubmit="return confirm('Yakin ingin menghapus penilaian ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center">Belum ada data penilaian.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
