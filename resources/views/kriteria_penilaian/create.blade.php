@extends('layouts.base')

@section('content')
<div class="container mt-4">
    <h2>Tambah Kriteria Penilaian</h2>

    <form action="{{ route('kriteria_penilaian.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="nama" class="form-label">Nama Kriteria</label>
            <input type="text" name="nama" id="nama" class="form-control" required value="{{ old('nama') }}">
        </div>

        <div class="mb-3">
            <label for="bobot" class="form-label">Bobot</label>
            <input type="number" name="bobot" id="bobot" class="form-control" step="0.01" min="0" max="1" required value="{{ old('bobot') }}">
            <small class="form-text text-muted">Masukkan bobot dalam desimal, misal 0.25</small>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
