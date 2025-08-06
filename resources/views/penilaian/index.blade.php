@extends('layouts.base')

@section('content')
    <div class="container mt-4">
        <h2>Daftar Penilaian</h2>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <a href="{{ route('penilaian.create') }}" class="btn btn-primary mb-3">Tambah Penilaian</a>
        <a href="{{ route('penilaian.pdf') }}" class="btn btn-danger mb-3">Export PDF</a>

        {{-- Filter berdasarkan semester --}}
        <form method="GET" action="{{ route('penilaian.index') }}">
            <select name="id_semester" class="form-select" onchange="this.form.submit()">
                <option value="">-- Semua Semester --</option>
                @foreach ($daftarSemester as $smt)
                    <option value="{{ $smt->id }}" {{ $idSemesterDipilih == $smt->id ? 'selected' : '' }}>
                        {{ ucfirst($smt->semester) }} - {{ $smt->tahun }}
                    </option>
                @endforeach
            </select>
        </form>



        {{-- Tabel Data --}}
    <table class="table table-bordered table-striped align-middle">
 <thead class="table-white">
    <tr>
        <th>#</th>
        <th>Nama User</th>
        <th>Nama Guru</th> {{-- ✅ Kolom Guru --}}
        <th>Kelas</th>
        <th>Mapel</th>
        <th>Semester</th>
        <th>Tanggal</th>
        <th>Kriteria & Nilai</th>
        <th>Aksi</th>
    </tr>
</thead>

    <tbody>
        @forelse ($penilaian as $smt)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $smt->user->name ?? 'User tidak ditemukan' }}</td> {{-- Ganti dari $smt->guru->nama --}}
                <td>{{ $smt->guru->nama ?? 'Guru tidak ditemukan' }}</td> {{-- ✅ Tampilkan nama guru --}}

                <td>{{ $smt->kelas->nama_kelas ?? '-' }}</td>
                <td>{{ $smt->mapel->nama_mapel ?? '-' }}</td>
                <td>
                    ID: {{ optional($smt->semester)->id ?? '-' }}<br>
                    Semester: {{ ucfirst(optional($smt->semester)->semester ?? '-') }}<br>
                    Tahun: {{ optional($smt->semester)->tahun ?? '-' }}
                </td>
                <td>{{ \Carbon\Carbon::parse($smt->tanggal)->format('d-m-Y') }}</td>
                <td>
                    <ul class="mb-0 ps-3">
                        @foreach ($smt->detailPenilaian as $detail)
                            <li>
                                {{ $detail->kriteria->nama ?? 'Kriteria tidak ditemukan' }}:
                                {{ $detail->nilai }}
                            </li>
                        @endforeach
                    </ul>
                </td>
                <td>
                    <a href="{{ route('penilaian.download', $smt->id_penilaian) }}" class="btn btn-sm btn-info">Download</a>
                    <a href="{{ route('penilaian.edit', $smt->id_penilaian) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('penilaian.destroy', $smt->id_penilaian) }}" method="POST"
                          class="d-inline" onsubmit="return confirm('Yakin ingin menghapus penilaian ini?');">
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
