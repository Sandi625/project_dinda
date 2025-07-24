@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4">Edit Nilai Siswa</h4>

    <form action="{{ route('nilai-siswa.update', $nilai->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nama Siswa</label>
            <input type="text" name="nama_siswa" class="form-control @error('nama_siswa') is-invalid @enderror" value="{{ old('nama_siswa', $nilai->nama_siswa) }}">
            @error('nama_siswa') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label>NISN</label>
            <input type="text" name="nisn" class="form-control @error('nisn') is-invalid @enderror" value="{{ old('nisn', $nilai->nisn) }}">
            @error('nisn') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label>Kelas</label>
            <input type="text" name="kelas" class="form-control @error('kelas') is-invalid @enderror" value="{{ old('kelas', $nilai->kelas) }}">
            @error('kelas') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label>Mata Pelajaran</label>
            <input type="text" name="mapel" class="form-control @error('mapel') is-invalid @enderror" value="{{ old('mapel', $nilai->mapel) }}">
            @error('mapel') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label>Kriteria</label>
            <input type="text" name="kriteria" class="form-control @error('kriteria') is-invalid @enderror" value="{{ old('kriteria', $nilai->kriteria) }}">
            @error('kriteria') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label>Semester</label>
            <select name="semester" class="form-select @error('semester') is-invalid @enderror">
                <option value="">-- Pilih Semester --</option>
                <option value="ganjil" {{ old('semester', $nilai->semester) == 'ganjil' ? 'selected' : '' }}>Ganjil</option>
                <option value="genap" {{ old('semester', $nilai->semester) == 'genap' ? 'selected' : '' }}>Genap</option>
            </select>
            @error('semester') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label>Nilai</label>
            <input type="number" name="nilai" class="form-control @error('nilai') is-invalid @enderror" value="{{ old('nilai', $nilai->nilai) }}">
            @error('nilai') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label>Tanggal</label>
            <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal', $nilai->tanggal) }}">
            @error('tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Tambahan Nama Guru --}}
        <div class="mb-3">
            <label>Nama Guru</label>
            <input type="text" name="nama_guru" class="form-control @error('nama_guru') is-invalid @enderror" value="{{ old('nama_guru', $nilai->nama_guru) }}">
            @error('nama_guru') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('nilai-siswa.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
