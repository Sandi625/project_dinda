@extends('layouts.base')

@section('content')
<div class="container">
    <h2>Tambah Mapel</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('mapel.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nama_mapel" class="form-label">Nama Mapel</label>
            <input type="text" class="form-control" name="nama_mapel" id="nama_mapel" value="{{ old('nama_mapel') }}" required>
        </div>



        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('mapel.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
