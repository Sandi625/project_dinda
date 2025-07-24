@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4">Tambah Nilai Siswa</h4>

    <form action="{{ route('nilai-siswa.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Nama Siswa</label>
            <input type="text" name="nama_siswa" class="form-control @error('nama_siswa') is-invalid @enderror" value="{{ old('nama_siswa') }}">
            @error('nama_siswa') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label>NISN</label>
            <input type="text" name="nisn" class="form-control @error('nisn') is-invalid @enderror" value="{{ old('nisn') }}">
            @error('nisn') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label>Kelas</label>
            <input type="text" name="kelas" class="form-control @error('kelas') is-invalid @enderror" value="{{ old('kelas') }}">
            @error('kelas') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label>Mata Pelajaran</label>
            <input type="text" name="mapel" class="form-control @error('mapel') is-invalid @enderror" value="{{ old('mapel') }}">
            @error('mapel') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label>Kriteria</label>
            <input type="text" name="kriteria" class="form-control @error('kriteria') is-invalid @enderror" value="{{ old('kriteria') }}">
            @error('kriteria') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label>Semester</label>
            <select name="semester" class="form-select @error('semester') is-invalid @enderror">
                <option value="">-- Pilih Semester --</option>
                <option value="ganjil" {{ old('semester') == 'ganjil' ? 'selected' : '' }}>Ganjil</option>
                <option value="genap" {{ old('semester') == 'genap' ? 'selected' : '' }}>Genap</option>
            </select>
            @error('semester') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label>Nilai</label>
            <input type="number" name="nilai" class="form-control @error('nilai') is-invalid @enderror" value="{{ old('nilai') }}">
            @error('nilai') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label>Tanggal</label>
            <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal') }}">
            @error('tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
    <label>Nama Guru</label>
    <input type="text" name="nama_guru" class="form-control @error('nama_guru') is-invalid @enderror" value="{{ old('nama_guru') }}">
    @error('nama_guru') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>


        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('nilai-siswa.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
