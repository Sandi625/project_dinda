@extends('layouts.base')

@section('title', 'Daftar Berita')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Daftar Berita</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Tutup">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="mb-3 text-right">
        <a href="{{ route('berita.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Berita
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover table-striped">
                <thead class="thead-white">
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Slug</th>
                        <th>Status</th>
                        <th>Dibuat</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $i => $berita)
                        <tr>
                            <td>{{ $data->firstItem() + $i }}</td>
                            <td>{{ $berita->judul }}</td>
                            <td>{{ $berita->slug }}</td>
                            <td>
                                @if($berita->status)
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td>{{ $berita->created_at->format('d M Y') }}</td>
                    <td>
    <a href="{{ route('berita.show', $berita) }}" class="btn btn-sm btn-info">
        <i class="fas fa-eye"></i>
    </a>

    <a href="{{ route('berita.edit', $berita) }}" class="btn btn-sm btn-warning">
        <i class="fas fa-edit"></i>
    </a>

    <form action="{{ route('berita.destroy', $berita) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus berita ini?')">
        @csrf
        @method('DELETE')
        <button class="btn btn-sm btn-danger">
            <i class="fas fa-trash-alt"></i>
        </button>
    </form>
</td>


                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada berita.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Paginate --}}
            <div class="mt-3">
                {{ $data->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
