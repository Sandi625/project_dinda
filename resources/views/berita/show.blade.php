@extends('layouts.base')

@section('title', 'Detail Berita')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Detail Berita</h1>

    <div class="card shadow-sm mb-4">
        <div class="card-body">

            {{-- Judul --}}
            <h4 class="text-primary font-weight-bold">{{ $berita->judul }}</h4>

            {{-- Slug dan Tanggal --}}
            <p class="text-muted mb-1">
                <i class="fas fa-link"></i> Slug: <code>{{ $berita->slug }}</code>
            </p>
            <p class="text-muted">
                <i class="fas fa-calendar-alt"></i> Diterbitkan: {{ $berita->created_at->format('d M Y H:i') }}
            </p>

            {{-- Gambar --}}
            @if ($berita->gambar)
                <div class="mb-3">
                    <img src="{{ asset('storage/' . $berita->gambar) }}"
                         class="img-thumbnail shadow-sm"
                         alt="Gambar Berita"
                         style="max-width: 100%; max-height: 350px; object-fit: cover;">
                </div>
            @endif

            {{-- Ringkasan --}}
            <p><strong>Ringkasan:</strong></p>
            <p>{{ $berita->ringkasan }}</p>

            {{-- Isi Berita --}}
            <hr>
            <p><strong>Isi Berita:</strong></p>
            <div class="mb-4">
                {!! $berita->isi_berita !!}
            </div>

            {{-- Status --}}
            <p>
                <strong>Status:</strong>
                @if($berita->status)
                    <span class="badge badge-success">Aktif</span>
                @else
                    <span class="badge badge-secondary">Nonaktif</span>
                @endif
            </p>

            {{-- Tombol Aksi --}}
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('berita.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <div>
                    <a href="{{ route('berita.edit', $berita) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form action="{{ route('berita.destroy', $berita) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus berita ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">
                            <i class="fas fa-trash-alt"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
