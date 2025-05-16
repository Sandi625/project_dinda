@extends('layouts.base')

@section('content')
<div class="container mt-4">
    <h2>Edit Kriteria Penilaian</h2>

    <form action="{{ route('kriteria_penilaian.update', $kriteria->id_kriteria) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nama" class="form-label">Nama Kriteria</label>
            <input type="text" name="nama" id="nama" class="form-control" required value="{{ old('nama', $kriteria->nama) }}">
        </div>

        <div class="mb-3">
            <label for="bobot" class="form-label">Bobot</label>
            <input type="number" name="bobot" id="bobot" class="form-control" step="0.01" min="0" max="1" required value="{{ old('bobot', $kriteria->bobot) }}">
            <small class="form-text text-muted">Masukkan bobot dalam desimal, misal 0.25</small>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
