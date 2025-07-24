@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Daftar Laporan Kinerja</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-3">
        <a href="{{ route('laporan_kinerja.create') }}" class="btn btn-primary">+ Tambah Laporan</a>
    </div>

    <form method="GET" class="mb-3">
        <div class="row">
            <div class="col-md-4">
                <select name="semester" class="form-select" onchange="this.form.submit()">
                    <option value="">-- Filter Semester --</option>
                    <option value="ganjil" {{ request('semester') == 'ganjil' ? 'selected' : '' }}>Ganjil</option>
                    <option value="genap" {{ request('semester') == 'genap' ? 'selected' : '' }}>Genap</option>
                </select>
            </div>
        </div>
    </form>

    @if ($laporan->count())
        <table class="table table-bordered table-white">
            <thead class="table-success">
                <tr>
                    <th>No</th>
                    <th>Semester</th>
                    <th>Tanggal Dibuat</th>
                    <th>Dibuat Oleh</th>
                    <th>Jumlah Indikator</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($laporan as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ ucfirst($item->semester) }}</td>
                        <td>{{ $item->created_at->format('d M Y') }}</td>
                        <td>
                            {{ optional($item->guru->user)->name ?? '-' }}
                        </td>
                        <td>
                            <ul class="mb-0 ps-3">
                                @foreach ($item->detail->take(2) as $detail)
                                    <li>{{ \Illuminate\Support\Str::limit($detail->indikator, 40) }}</li>
                                @endforeach

                                @if ($item->detail->count() > 2)
                                    <li><em>+{{ $item->detail->count() - 2 }} indikator lainnya</em></li>
                                @endif
                            </ul>
                        </td>
                        <td>
                            <a href="{{ route('laporan_kinerja.show', $item->id) }}" class="btn btn-sm btn-info">Lihat</a>
                            <a href="{{ route('laporan_kinerja.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>

                            <form action="{{ route('laporan_kinerja.destroy', $item->id) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Yakin ingin menghapus laporan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-muted">Belum ada laporan kinerja yang dikirim.</p>
    @endif
</div>
@endsection
