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

  <form method="GET" action="{{ route('laporan_kinerja.index') }}">
    <select name="id_semester" onchange="this.form.submit()">
        <option value="">-- Semua Semester --</option>
        @foreach ($semesters as $s)
            <option value="{{ $s->id }}" {{ request('id_semester') == $s->id ? 'selected' : '' }}>
                {{ ucfirst($s->semester) }} - {{ $s->tahun }}
            </option>
        @endforeach
    </select>
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
<td>
    @if ($item->semester)
        {{ ucfirst($item->semester->semester) }} - {{ $item->semester->tahun }}
    @else
        <em>Data tidak lengkap</em>
    @endif
</td>

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
