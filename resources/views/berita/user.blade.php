<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $berita->judul }} - Detail Berita</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .card-detail {
            max-width: 800px;
            margin: 0 auto;
        }
        .card-detail img {
            max-height: 400px;
            object-fit: cover;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">Berita Publik</a>
        </div>
    </nav>

    <div class="container">
        <div class="card card-detail shadow mb-5">
            @if ($berita->gambar)
                <img src="{{ asset('storage/' . $berita->gambar) }}" class="card-img-top" alt="{{ $berita->judul }}">
            @endif

            <div class="card-body">
                <h2 class="card-title text-primary">{{ $berita->judul }}</h2>

                <p class="text-muted mb-2">
                    <i class="fas fa-calendar-alt"></i>
                    {{ $berita->created_at->format('d M Y') }} &nbsp;|&nbsp;
                    <i class="fas fa-user"></i> {{ $berita->creator->name ?? 'Admin' }}
                </p>

                <hr>

                <h5>Ringkasan:</h5>
                <p>{{ $berita->ringkasan }}</p>

                <hr>

                <h5>Isi Berita:</h5>
                <div>
                    {!! $berita->isi_berita !!}
                </div>

                <div class="mt-4 text-right">
                    <a href="{{ route('home') }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Font Awesome & Bootstrap JS --}}
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
