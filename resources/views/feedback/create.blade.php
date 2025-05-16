@extends('layouts.base')

@section('content')
<div class="container mt-4">
    <h2>Tambah Feedback</h2>

    <form action="{{ route('feedback.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="id_penilaian" class="form-label">Penilaian</label>
            <select name="id_penilaian" class="form-select" required>
                <option value="">-- Pilih Penilaian --</option>
                @foreach ($penilaians as $penilaian)
                    <option value="{{ $penilaian->id_penilaian }}">Guru: {{ $penilaian->guru->nama ?? '-' }} | Periode: {{ $penilaian->periode }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="isi" class="form-label">Isi Feedback</label>
            <textarea name="isi" class="form-control" required>{{ old('isi') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" required value="{{ old('tanggal') }}">
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
