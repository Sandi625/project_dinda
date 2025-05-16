@extends('layouts.base')

@section('content')
<div class="container mt-4">
    <h2>Daftar Feedback</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('feedback.create') }}" class="btn btn-primary mb-3">Tambah Feedback</a>

    <table class="table table-bordered table-striped align-middle">
        <thead class="table-primary">
            <tr>
                <th>#</th>
                <th>Penilaian</th>
                <th>Isi</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($feedbacks as $f)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>Periode: {{ $f->penilaian->periode ?? '-' }}<br>Guru: {{ $f->penilaian->guru->nama ?? '-' }}</td>
                <td>{{ $f->isi }}</td>
                <td>{{ \Carbon\Carbon::parse($f->tanggal)->format('d-m-Y') }}</td>
                <td>
                    <a href="{{ route('feedback.edit', $f->id_feedback) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('feedback.destroy', $f->id_feedback) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Belum ada data feedback.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
