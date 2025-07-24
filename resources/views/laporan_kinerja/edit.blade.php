@extends('layouts.app')

@section('title', 'Edit Laporan Kinerja')

@section('content')
<div class="container mt-4">
    <h3>Edit Laporan Kinerja</h3>

    <form action="{{ route('laporan_kinerja.update', $laporan->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="semester" class="form-label">Semester</label>
            <select name="semester" id="semester" class="form-select" required>
                <option value="ganjil" {{ $laporan->semester === 'ganjil' ? 'selected' : '' }}>Ganjil</option>
                <option value="genap" {{ $laporan->semester === 'genap' ? 'selected' : '' }}>Genap</option>
            </select>
        </div>

        <hr>
        <h5>Detail Laporan</h5>

        @foreach ($laporan->detail as $index => $detail)
            <div class="card mb-3">
                <div class="card-body">
                    <input type="hidden" name="detail_ids[]" value="{{ $detail->id }}">

                    <div class="mb-2">
                        <label>Kategori</label>
                        <input type="text" name="kategori[]" class="form-control" value="{{ old('kategori.' . $index, $detail->kategori) }}" required>
                    </div>

                    <div class="mb-2">
                        <label>Indikator</label>
                        <input type="text" name="indikator[]" class="form-control" value="{{ old('indikator.' . $index, $detail->indikator) }}" required>
                    </div>

                    <div class="mb-2">
                        <label>Keterangan</label>
                        <textarea name="keterangan[]" class="form-control">{{ old('keterangan.' . $index, $detail->keterangan) }}</textarea>
                    </div>

                    <div class="mb-2">
                        <label>File Bukti (Biarkan kosong jika tidak ingin mengubah)</label>
                        <input type="file" name="file_bukti[]" class="form-control">
                        @if ($detail->file_bukti)
                            <small>File saat ini: <a href="{{ asset('storage/' . $detail->file_bukti) }}" target="_blank">Lihat</a></small>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach

        <button type="submit" class="btn btn-primary">Update Laporan</button>
        <a href="{{ route('laporan_kinerja.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
