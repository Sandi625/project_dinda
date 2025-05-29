@extends('layouts.app')

@section('title', 'Edit Feedback')

@section('content')
    <h1>Edit Feedback</h1>

  <div class="card mb-4 shadow-sm">
    <div class="card-header bg-success text-light">
        <h5 class="mb-0">Edit Feedback - Informasi Penilaian</h5>
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item">
            <strong>ID Penilaian:</strong> {{ $penilaian->id_penilaian }}
        </li>
        <li class="list-group-item">
            <strong>Guru:</strong> {{ ucwords(strtolower($penilaian->guru->nama ?? 'Tidak ada guru')) }}
        </li>
        <li class="list-group-item">
            <strong>Periode:</strong> {{ $penilaian->periode }}
        </li>
    </ul>
</div>


    <form action="{{ route('halamanguru.update', $feedback->id_feedback) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="isi" class="form-label">Isi Feedback</label>
            <textarea class="form-control @error('isi') is-invalid @enderror" id="isi" name="isi" rows="4" required>{{ old('isi', $feedback->isi) }}</textarea>
            @error('isi')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal Feedback</label>
            <input type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" name="tanggal" value="{{ old('tanggal', $feedback->tanggal) }}" required>
            @error('tanggal')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update Feedback</button>
        <a href="{{ route('halamanguru.index') }}" class="btn btn-secondary">Batal</a>
    </form>
@endsection
