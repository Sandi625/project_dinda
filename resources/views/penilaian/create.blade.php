@extends('layouts.base')

@section('content')
<div class="container mt-4">
    <h2>Tambah Penilaian</h2>

    <form action="{{ route('penilaian.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="id_guru" class="form-label">Guru</label>
            <select name="id_guru" class="form-select" required>
                <option value="">-- Pilih Guru --</option>
                @foreach ($gurus as $guru)
                    <option value="{{ $guru->id_guru }}">{{ $guru->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="periode" class="form-label">Periode</label>
            <input type="text" name="periode" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" required>
        </div>

        <h5>Detail Penilaian</h5>
       <div id="detail-penilaian">
    @foreach ($kriterias as $kriteria)
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Nama Kriteria: {{ $kriteria->nama }}</label>
                <input type="hidden" name="detail[{{ $loop->index }}][id_kriteria]" value="{{ $kriteria->id_kriteria }}">
                <input type="number" name="detail[{{ $loop->index }}][nilai]" class="form-control" placeholder="Nilai untuk {{ $kriteria->nama }}" required>
            </div>
        </div>
    @endforeach
</div>


        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
