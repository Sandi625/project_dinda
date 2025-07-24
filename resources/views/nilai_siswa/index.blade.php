@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4">Daftar Nilai Siswa</h4>

    <div class="row mb-3">
        <div class="col-md-6">
            <a href="{{ route('nilai-siswa.create') }}" class="btn btn-primary">+ Tambah Nilai</a>
        </div>
        <div class="col-md-6">
            <form action="{{ route('nilai-siswa.import') }}" method="POST" enctype="multipart/form-data" class="d-flex justify-content-end">
                @csrf
                <input type="file" name="file" class="form-control me-2" required>
                <button type="submit" class="btn btn-success">Upload Excel</button>
            </form>
        </div>
    </div>

    {{-- Success message --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Error from controller --}}
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    {{-- Validation error for file --}}
    @if ($errors->has('file'))
        <div class="alert alert-danger">
            {{ $errors->first('file') }}
        </div>
    @endif

    {{-- Rata-rata nilai --}}
    @if($nilai->count())
        <div class="alert alert-info">
            <strong>Rata-rata Nilai Keseluruhan:</strong> {{ number_format($rataRata, 2) }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead class="table-success">
            <tr>
                <th>Nama</th>
                <th>NISN</th>
                <th>Kelas</th>
                <th>Mapel</th>
                <th>Kriteria</th>
                <th>Semester</th>
                <th>Nilai</th>
                <th>Tanggal</th>
                <th>Nama Guru</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($nilai as $item)
                <tr>
                    <td>{{ $item->nama_siswa }}</td>
                    <td>{{ $item->nisn }}</td>
                    <td>{{ $item->kelas }}</td>
                    <td>{{ $item->mapel }}</td>
                    <td>{{ $item->kriteria }}</td>
                    <td>{{ ucfirst($item->semester) }}</td>
                    <td>{{ $item->nilai }}</td>
                    <td>{{ $item->tanggal }}</td>
                    <td>{{ $item->nama_guru ?? '-' }}</td>
                    <td>
                        <a href="{{ route('nilai-siswa.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('nilai-siswa.destroy', $item->id) }}" method="POST" style="display:inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center">Tidak ada data nilai siswa.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Fallback untuk semua error --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
@endsection
