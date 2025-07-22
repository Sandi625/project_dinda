@extends('layouts.app')

@section('title', 'Edit Laporan Pembelajaran')

@section('content')
<div class="container mt-4">
    <h4 class="mb-4">✏️ Edit Laporan Pembelajaran Bulanan</h4>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('laporan.update', $laporan->id_laporan) }}" method="POST">
        @csrf
        @method('PUT')
<div class="mb-3">
    <label for="id_kelas" class="form-label">Kelas</label>
    <select name="id_kelas" id="id_kelas" class="form-select @error('id_kelas') is-invalid @enderror" required>
        <option value="">-- Pilih Kelas --</option>
        @foreach ($kelas as $k)
            <option value="{{ $k->id }}" {{ $laporan->id_kelas == $k->id ? 'selected' : '' }}>
                {{ $k->nama_kelas }}
            </option>
        @endforeach
    </select>
    @error('id_kelas')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="id_mapel" class="form-label">Mata Pelajaran</label>
    <select name="id_mapel" id="id_mapel" class="form-select @error('id_mapel') is-invalid @enderror" required>
        <option value="">-- Pilih Mapel --</option>
        @foreach ($mapel as $m)
            <option value="{{ $m->id }}" {{ $laporan->id_mapel == $m->id ? 'selected' : '' }}>
                {{ $m->nama_mapel }}
            </option>
        @endforeach
    </select>
    @error('id_mapel')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


        <div class="mb-3">
            <label for="bulan" class="form-label">Bulan</label>
            <input type="text" name="bulan" id="bulan" class="form-control" value="{{ $laporan->bulan }}" required>
        </div>

        <div class="mb-3">
            <label for="materi" class="form-label">Materi yang Diajarkan</label>
            <textarea name="materi" id="materi" rows="3" class="form-control">{{ $laporan->materi }}</textarea>
        </div>

        <div class="mb-3">
            <label for="metode" class="form-label">Metode Pembelajaran</label>
            <textarea name="metode" id="metode" rows="2" class="form-control">{{ $laporan->metode }}</textarea>
        </div>

        <div class="mb-3">
            <label for="jumlah_pertemuan" class="form-label">Jumlah Pertemuan</label>
            <input type="number" name="jumlah_pertemuan" id="jumlah_pertemuan" class="form-control" value="{{ $laporan->jumlah_pertemuan }}">
        </div>

        <div class="mb-3">
            <label for="rata_kehadiran" class="form-label">Rata-rata Kehadiran Siswa (%)</label>
            <input type="text" name="rata_kehadiran" id="rata_kehadiran" class="form-control" value="{{ $laporan->rata_kehadiran }}">
        </div>

        <div class="mb-3">
            <label for="evaluasi" class="form-label">Evaluasi atau Asesmen</label>
            <textarea name="evaluasi" id="evaluasi" rows="2" class="form-control">{{ $laporan->evaluasi }}</textarea>
        </div>

        <div class="mb-3">
            <label for="kendala" class="form-label">Kendala yang Dihadapi</label>
            <textarea name="kendala" id="kendala" rows="2" class="form-control">{{ $laporan->kendala }}</textarea>
        </div>

        <div class="mb-3">
            <label for="solusi" class="form-label">Solusi atau Tindak Lanjut</label>
            <textarea name="solusi" id="solusi" rows="2" class="form-control">{{ $laporan->solusi }}</textarea>
        </div>

        <div class="mb-3">
            <label for="catatan" class="form-label">Catatan Tambahan (Opsional)</label>
            <textarea name="catatan" id="catatan" rows="2" class="form-control">{{ $laporan->catatan }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Update Laporan</button>
        <a href="{{ route('laporan.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
