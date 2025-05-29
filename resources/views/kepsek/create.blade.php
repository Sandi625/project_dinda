@extends('layouts.master')

@section('title', 'Tambah Penilaian Guru')

@section('content')
<div class="container mt-4">
    <h1>Tambah Penilaian Guru</h1>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('kepsek.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="id_guru" class="form-label">Pilih Guru</label>
            <select name="id_guru" id="id_guru" class="form-select @error('id_guru') is-invalid @enderror">
                <option value="">-- Pilih Guru --</option>
                @foreach($guru as $g)
                    <option value="{{ $g->id_guru }}" {{ old('id_guru') == $g->id_guru ? 'selected' : '' }}>{{ $g->nama }}</option>
                @endforeach
            </select>
            @error('id_guru')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="periode" class="form-label">Periode</label>
            <input type="text" name="periode" id="periode" class="form-control @error('periode') is-invalid @enderror" value="{{ old('periode') }}">
            @error('periode')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal Penilaian</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal', date('Y-m-d')) }}">
            @error('tanggal')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <h5>Nilai Kriteria</h5>
        @foreach($kriteria as $k)
            <div class="mb-3">
                <label for="nilai_{{ $k->id_kriteria }}" class="form-label">{{ $k->nama }}</label>
                <input
                    type="number"
                    step="0.01"
                    min="0" max="100"
                    name="nilai[{{ $k->id_kriteria }}]"
                    id="nilai_{{ $k->id_kriteria }}"
                    class="form-control @error('nilai.'.$k->id_kriteria) is-invalid @enderror"
                    value="{{ old('nilai.'.$k->id_kriteria) }}"
                >
                @error('nilai.'.$k->id_kriteria)
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        @endforeach

        <button type="submit" class="btn btn-success">Simpan Penilaian</button>
        <a href="{{ route('kepsek.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
