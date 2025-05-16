@extends('layouts.base')

@section('content')
<div class="container mt-4">
    <h2>Daftar Kriteria Penilaian</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('kriteria_penilaian.create') }}" class="btn btn-primary mb-3">Tambah Kriteria</a>

    <table class="table table-bordered table-striped align-middle">
        <thead class="table-primary">
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Bobot</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($kriteria as $k)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $k->nama }}</td>
                <td>{{ $k->bobot }}</td>
                <td>
                    <a href="{{ route('kriteria_penilaian.edit', $k->id_kriteria) }}" class="btn btn-sm btn-warning">Edit</a>

                    <form action="{{ route('kriteria_penilaian.destroy', $k->id_kriteria) }}" method="POST" class="d-inline"
                        onsubmit="return confirm('Yakin ingin menghapus kriteria ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">Belum ada data kriteria.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
