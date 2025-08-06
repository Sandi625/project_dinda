@extends('layouts.base')

@section('title', 'Edit Semester')

@section('content')
<div class="container mt-4">
    <h2 class="mb-3">Edit Semester</h2>

    {{-- Tampilkan error validasi jika ada --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form Edit --}}
    <form action="{{ route('semester.update', $semester->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="semester" class="form-label">Semester</label>
            <select name="semester" id="semester" class="form-select" required>
                <option value="">-- Pilih Semester --</option>
                <option value="ganjil" {{ $semester->semester == 'ganjil' ? 'selected' : '' }}>Ganjil</option>
                <option value="genap" {{ $semester->semester == 'genap' ? 'selected' : '' }}>Genap</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="tahun" class="form-label">Tahun</label>
            <select name="tahun" id="tahun" class="form-select" required>
                <option value="">-- Pilih Tahun --</option>
                @for ($year = 2023; $year <= 2027; $year++)
                    <option value="{{ $year }}" {{ $semester->tahun == $year ? 'selected' : '' }}>{{ $year }}</option>
                @endfor
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('semester.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
