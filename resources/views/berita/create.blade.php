@extends('layouts.base')

@section('title', 'Tambah Berita')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Tambah Berita</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan!</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('berita.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Judul --}}
        <div class="form-group">
            <label for="judul">Judul Berita</label>
            <input type="text" name="judul" class="form-control" value="{{ old('judul') }}" required>
        </div>

        {{-- Ringkasan --}}
        <div class="form-group">
            <label for="ringkasan">Ringkasan</label>
            <textarea name="ringkasan" rows="3" class="form-control" required>{{ old('ringkasan') }}</textarea>
        </div>

        {{-- Isi Berita --}}
        <div class="form-group">
            <label for="isi_berita">Isi Berita</label>
            <textarea name="isi_berita" rows="8" class="form-control" required>{{ old('isi_berita') }}</textarea>
        </div>

        {{-- Gambar --}}
        <div class="form-group">
            <label for="gambar">Gambar (opsional)</label>
            <input type="file" name="gambar" class="form-control-file">
        </div>

        {{-- Status --}}
        <div class="form-group form-check">
            <input type="checkbox" name="status" class="form-check-input" id="status" {{ old('status') ? 'checked' : '' }}>
            <label class="form-check-label" for="status">Tampilkan berita</label>
        </div>

        <div class="form-group d-flex justify-content-between">
            <a href="{{ route('berita.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-plus-circle"></i> Simpan
            </button>
        </div>
    </form>
</div>
@endsection
