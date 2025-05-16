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

    <table class="table table-bordered table-striped align-middle">
        <thead class="table-primary">
            <tr>
                <th>#</th>
                <th>Guru</th>
                <th>Periode</th>
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
                <td>{{ $p->periode }}</td>
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
                <td colspan="6" class="text-center">Belum ada data penilaian.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
