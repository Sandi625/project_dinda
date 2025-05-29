@extends('layouts.master')

@section('title', 'Edit Penilaian Guru')

@section('content')
<div class="container mt-4">
    <h1>Edit Penilaian Guru</h1>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('kepsek.update', $penilaian->id_penilaian) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="id_guru" class="form-label">Guru</label>
            <select name="id_guru" id="id_guru" class="form-select" disabled>
                @foreach($guru as $g)
                    <option value="{{ $g->id_guru }}" {{ $penilaian->id_guru == $g->id_guru ? 'selected' : '' }}>{{ $g->nama }}</option>
                @endforeach
            </select>
            <input type="hidden" name="id_guru" value="{{ $penilaian->id_guru }}">
        </div>

        <div class="mb-3">
            <label for="periode" class="form-label">Periode</label>
            <input type="text" name="periode" id="periode" class="form-control @error('periode') is-invalid @enderror" value="{{ old('periode', $penilaian->periode) }}">
            @error('periode')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal Penilaian</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal', $penilaian->tanggal->format('Y-m-d')) }}">
            @error('tanggal')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <h5>Nilai Kriteria</h5>
        @foreach($kriteria as $k)
            @php
                $nilaiKriteria = $penilaian->detailPenilaian->firstWhere('id_kriteria', $k->id_kriteria);
            @endphp
            <div class="mb-3">
                <label for="nilai_{{ $k->id_kriteria }}" class="form-label">{{ $k->nama }}</label>
                <input
                    type="number"
                    step="0.01"
                    min="0" max="100"
                    name="nilai[{{ $k->id_kriteria }}]"
                    id="nilai_{{ $k->id_kriteria }}"
                    class="form-control @error('nilai.'.$k->id_kriteria) is-invalid @enderror"
                    value="{{ old('nilai.'.$k->id_kriteria, $nilaiKriteria->nilai ?? '') }}"
                >
                @error('nilai.'.$k->id_kriteria)
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        @endforeach

        <button type="submit" class="btn btn-primary">Update Penilaian</button>
        <a href="{{ route('kepsek.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
