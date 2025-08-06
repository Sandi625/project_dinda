@extends('layouts.master')

@section('title', 'Daftar Penilaian User')

@section('content')
<div class="container mt-4">
    <h1>Daftar Penilaian User</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <a href="{{ route('kepsek.create') }}" class="btn btn-primary mb-3">Tambah Penilaian</a>

    <form method="GET" action="{{ route('kepsek.index') }}" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <label for="id_semester" class="form-label">Filter Semester</label>
                <select name="id_semester" id="id_semester" class="form-select" onchange="this.form.submit()">
                    <option value="">-- Semua Semester --</option>
                    @foreach ($daftarSemester as $semester)
                        <option value="{{ $semester->id }}"
                            {{ request('id_semester') == $semester->id ? 'selected' : '' }}>
                            {{ ucfirst($semester->semester) }} - {{ $semester->tahun }}
                        </option>
                    @endforeach
                </select>

                @if(request()->has('id_semester') && request('id_semester') != '')
                    <a href="{{ route('kepsek.index') }}" class="btn btn-secondary mt-2">Reset Filter</a>
                @endif
            </div>
        </div>
    </form>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama User</th>
                <th>Semester</th>
                <th>Tanggal</th>
                <th>Detail Nilai</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($penilaian as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->user->name ?? '-' }}</td>
                <td>{{ $item->semester->semester ?? '-' }} - {{ $item->semester->tahun ?? '' }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                <td>
                    @if($item->detailPenilaian->isNotEmpty())
                        <ul class="mb-0">
                            @foreach($item->detailPenilaian as $detail)
                                <li>{{ $detail->kriteria->nama ?? 'Kriteria tidak ditemukan' }}: {{ $detail->nilai }}</li>
                            @endforeach
                        </ul>
                    @else
                        <span class="text-muted">Belum ada nilai.</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('kepsek.edit', $item->id_penilaian) }}" class="btn btn-warning btn-sm">Edit</a>

                    <form action="{{ route('kepsek.destroy', $item->id_penilaian) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Yakin ingin menghapus penilaian ini?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Hapus</button>
                    </form>

                    <a href="{{ route('penilaian.kepsek.download', $item->id_penilaian) }}" class="btn btn-primary btn-sm" target="_blank">Download PDF</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Belum ada data penilaian.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

