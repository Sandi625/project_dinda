@extends('layouts.base')

@section('content')
<div class="container">
    <h4 class="mb-4">Daftar Program Studi</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('prodi.create') }}" class="btn btn-primary mb-3">+ Tambah Prodi</a>

    <form action="{{ route('prodi.import') }}" method="POST" enctype="multipart/form-data" class="d-flex mb-3">
    @csrf
    <input type="file" name="file" class="form-control me-2" required>
    <button type="submit" class="btn btn-success">Import Excel</button>
</form>


    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Prodi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($prodis as $index => $prodi)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $prodi->nama_prodi }}</td>
                    <td>
                        <a href="{{ route('prodi.edit', $prodi->id) }}" class="btn btn-sm btn-warning">Edit</a>

                        <form action="{{ route('prodi.destroy', $prodi->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin ingin menghapus?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" type="submit">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">Belum ada data prodi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
