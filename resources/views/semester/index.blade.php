@extends('layouts.base')

@section('title', 'Daftar Semester')

@section('content')
<div class="container mt-4">
    <h2 class="mb-3">Manajemen Semester</h2>

    {{-- Notifikasi sukses --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Tombol Tambah --}}
    <a href="{{ route('semester.create') }}" class="btn btn-primary mb-3">+ Tambah Semester</a>

    {{-- Tabel Data Semester --}}
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Semester</th>
                <th>Tahun</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($semesters as $semester)
                <tr>
                    <td>{{ $semester->id }}</td>
                    <td>{{ ucfirst($semester->semester) }}</td>
                    <td>{{ $semester->tahun }}</td>
                    <td>
                        <a href="{{ route('semester.edit', $semester->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('semester.destroy', $semester->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Belum ada data semester.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
