@extends('layouts.app')

@section('title', 'Tambah Feedback')

@section('content')
    <h1>Tambah Feedback</h1>

    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">Informasi Penilaian</h5>
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <strong>ID Penilaian:</strong> {{ $penilaian->id_penilaian }}
            </li>
            <li class="list-group-item">
                <strong>Guru:</strong> {{ ucwords(strtolower($penilaian->user->nama ?? 'Tidak ada user')) }}
            </li>
            <li class="list-group-item">
                <strong>Periode:</strong> {{ $penilaian->periode }}
            </li>
        </ul>
    </div>

    <form action="{{ route('halamanguru.store') }}" method="POST">
        @csrf

        <input type="hidden" name="id_penilaian" value="{{ $penilaian->id_penilaian }}">

        <div class="mb-3">
            <label for="feedback_guru" class="form-label">Feedback Guru</label>
            <textarea class="form-control @error('feedback_guru') is-invalid @enderror" id="feedback_guru" name="feedback_guru" rows="4">{{ old('feedback_guru') }}</textarea>
            @error('feedback_guru')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal Feedback</label>
            <input type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required>
            @error('tanggal')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Simpan Feedback</button>
        <a href="{{ route('halamanguru.index') }}" class="btn btn-secondary">Batal</a>
    </form>
@endsection

