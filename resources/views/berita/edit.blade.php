@extends('layouts.base')

@section('title', 'Edit Berita')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Edit Berita</h1>

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

    <form action="{{ route('berita.update', $berita) }}" method="POST" enctype="multipart/form-data">

        @csrf
        @method('PUT')

        {{-- Judul --}}
        <div class="form-group">
            <label for="judul">Judul Berita</label>
            <input type="text" name="judul" class="form-control" value="{{ old('judul', $berita->judul) }}" required>
        </div>

        {{-- Ringkasan --}}
        <div class="form-group">
            <label for="ringkasan">Ringkasan</label>
            <textarea name="ringkasan" rows="3" class="form-control" required>{{ old('ringkasan', $berita->ringkasan) }}</textarea>
        </div>

        {{-- Isi Berita --}}
        <div class="form-group">
            <label for="isi_berita">Isi Berita</label>
            <textarea name="isi_berita" rows="8" class="form-control" required>{{ old('isi_berita', $berita->isi_berita) }}</textarea>
        </div>

        {{-- Gambar --}}
      <div class="form-group">
    <label for="gambar">Gambar (opsional)</label>
    <input type="file" name="gambar" class="form-control-file">

    @if (!empty($berita->gambar) && \Illuminate\Support\Facades\Storage::disk('public')->exists($berita->gambar))
        <div class="mt-2">
            <img src="{{ asset('storage/' . $berita->gambar) }}" alt="Gambar Berita" class="img-thumbnail" style="max-height: 150px;">
        </div>
    @endif
</div>


        {{-- Status --}}
        <div class="form-group form-check">
            <input type="checkbox" name="status" class="form-check-input" id="status" {{ $berita->status ? 'checked' : '' }}>
            <label class="form-check-label" for="status">Tampilkan berita</label>
        </div>

        <div class="form-group d-flex justify-content-between">
            <a href="{{ route('berita.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
