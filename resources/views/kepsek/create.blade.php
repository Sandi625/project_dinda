@extends('layouts.master')

@section('title', 'Tambah Penilaian Guru')

@section('content')
<div class="container mt-4">
    <h1>Tambah Penilaian Guru</h1>

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('kepsek.store') }}" method="POST">
        @csrf

        {{-- Guru --}}
        <div class="mb-3">
            <label for="id_guru" class="form-label">Pilih Guru</label>
            <select name="id_guru" id="id_guru" class="form-select @error('id_guru') is-invalid @enderror" required>
                <option value="">-- Pilih Guru --</option>
                @foreach ($guru as $g)
                    <option value="{{ $g->id_guru }}" {{ old('id_guru') == $g->id_guru ? 'selected' : '' }}>
                        {{ $g->nama }}
                    </option>
                @endforeach
            </select>
            @error('id_guru')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- User --}}
        <div class="mb-3">
            <label for="id_user" class="form-label">Pilih Akun</label>
            <select name="id_user" class="form-select @error('id_user') is-invalid @enderror" required>
                <option value="">-- Pilih User --</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id_user }}" {{ old('id_user') == $user->id_user ? 'selected' : '' }}>
                        {{ $user->name }} ({{ $user->role }})
                    </option>
                @endforeach
            </select>
            @error('id_user')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Kelas --}}
        <div class="mb-3">
            <label for="id_kelas" class="form-label">Pilih Kelas</label>
            <select name="id_kelas" id="id_kelas" class="form-select @error('id_kelas') is-invalid @enderror" required>
                <option value="">-- Pilih Kelas --</option>
                @foreach ($kelas as $k)
                    <option value="{{ $k->id }}" {{ old('id_kelas') == $k->id ? 'selected' : '' }}>
                        {{ $k->nama_kelas }}
                    </option>
                @endforeach
            </select>
            @error('id_kelas')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Mapel --}}
        <div class="mb-3">
            <label for="id_mapel" class="form-label">Pilih Mata Pelajaran</label>
            <select name="id_mapel" id="id_mapel" class="form-select @error('id_mapel') is-invalid @enderror" required>
                <option value="">-- Pilih Mapel --</option>
                @foreach ($mapel as $m)
                    <option value="{{ $m->id }}" {{ old('id_mapel') == $m->id ? 'selected' : '' }}>
                        {{ $m->nama_mapel }}
                    </option>
                @endforeach
            </select>
            @error('id_mapel')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Semester --}}
        <div class="mb-3">
            <label for="semester" class="form-label">Semester</label>
            <select name="semester" id="semester" class="form-select @error('semester') is-invalid @enderror" required>
                <option value="">-- Pilih Semester --</option>
                <option value="ganjil" {{ old('semester') == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                <option value="genap" {{ old('semester') == 'Genap' ? 'selected' : '' }}>Genap</option>
            </select>
            @error('semester')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Tanggal --}}
        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal Penilaian</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control @error('tanggal') is-invalid @enderror"
                value="{{ old('tanggal', date('Y-m-d')) }}" required>
            @error('tanggal')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Nilai Kriteria --}}
        <h5>Nilai Kriteria</h5>
        @foreach ($kriteria as $k)
            <div class="mb-3">
                <label for="nilai_{{ $k->id_kriteria }}" class="form-label">{{ $k->nama }}</label>
                <input type="number" step="0.01" min="0" max="100" name="nilai[{{ $k->id_kriteria }}]"
                    id="nilai_{{ $k->id_kriteria }}"
                    class="form-control @error('nilai.' . $k->id_kriteria) is-invalid @enderror"
                    value="{{ old('nilai.' . $k->id_kriteria) }}" required>
                @error('nilai.' . $k->id_kriteria)
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        @endforeach

        <button type="submit" class="btn btn-success">Simpan Penilaian</button>
        <a href="{{ route('kepsek.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
