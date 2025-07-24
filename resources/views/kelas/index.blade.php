@extends('layouts.base')

@section('content')
<div class="container">
    <h2>Daftar Kelas</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('kelas.create') }}" class="btn btn-primary mb-3">+ Tambah Kelas</a>

    <form action="{{ route('kelas.import') }}" method="POST" enctype="multipart/form-data" class="d-flex mb-3">
    @csrf
    <input type="file" name="file" class="form-control me-2" required>
    <button type="submit" class="btn btn-success">Import Excel</button>
</form>


    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kelas</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kelas as $index => $k)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $k->nama_kelas }}</td>
                <td>
                    <a href="{{ route('kelas.edit', $k->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('kelas.destroy', $k->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
            @if($kelas->isEmpty())
                <tr><td colspan="3" class="text-center">Belum ada data kelas</td></tr>
            @endif
        </tbody>
    </table>
</div>
@endsection
