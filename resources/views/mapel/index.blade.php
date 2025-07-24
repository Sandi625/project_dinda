@extends('layouts.base')

@section('content')
<div class="container">
    <h2>Daftar Mapel</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('mapel.create') }}" class="btn btn-primary mb-3">+ Tambah Mapel</a>

    <form action="{{ route('mapel.import') }}" method="POST" enctype="multipart/form-data" class="d-flex mb-3">
    @csrf
    <input type="file" name="file" class="form-control me-2" required>
    <button type="submit" class="btn btn-success">Import Mapel</button>
</form>


    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Mapel</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($mapel as $index => $m)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $m->nama_mapel }}</td>
                <td>
                    <a href="{{ route('mapel.edit', $m->id) }}" class="btn btn-warning btn-sm">Edit</a>

                    <form action="{{ route('mapel.destroy', $m->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach

            @if($mapel->isEmpty())
            <tr>
                <td colspan="4" class="text-center">Belum ada data mapel</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>
@endsection
