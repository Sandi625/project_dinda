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

        {{-- Guru --}}
        <div class="mb-3">
            <label for="id_guru" class="form-label">Guru</label>
            <select id="id_guru" class="form-select" disabled>
                @foreach($guru as $g)
                    <option value="{{ $g->id_guru }}" {{ $penilaian->id_guru == $g->id_guru ? 'selected' : '' }}>
                        {{ $g->nama }}
                    </option>
                @endforeach
            </select>
            <input type="hidden" name="id_guru" value="{{ $penilaian->id_guru }}">
        </div>

        {{-- User --}}
        <div class="mb-3">
            <label for="id_user" class="form-label">User Pembuat</label>
            <select name="id_user" class="form-select @error('id_user') is-invalid @enderror" required>
                <option value="">-- Pilih User --</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id_user }}" {{ old('id_user', $penilaian->id_user) == $user->id_user ? 'selected' : '' }}>
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
            <label for="id_kelas" class="form-label">Kelas</label>
            <select name="id_kelas" id="id_kelas" class="form-select @error('id_kelas') is-invalid @enderror" required>
                <option value="">-- Pilih Kelas --</option>
                @foreach($kelas as $k)
                    <option value="{{ $k->id }}" {{ old('id_kelas', $penilaian->id_kelas) == $k->id ? 'selected' : '' }}>
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
            <label for="id_mapel" class="form-label">Mata Pelajaran</label>
            <select name="id_mapel" id="id_mapel" class="form-select @error('id_mapel') is-invalid @enderror" required>
                <option value="">-- Pilih Mapel --</option>
                @foreach($mapel as $m)
                    <option value="{{ $m->id }}" {{ old('id_mapel', $penilaian->id_mapel) == $m->id ? 'selected' : '' }}>
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
    <label for="id_semester" class="form-label">Semester</label>
    <select name="id_semester" id="id_semester" class="form-select @error('id_semester') is-invalid @enderror" required>
        <option value="">-- Pilih Semester --</option>
        @foreach ($semesters as $smt)
            <option value="{{ $smt->id }}"
                {{ old('id_semester', $penilaian->id_semester) == $smt->id ? 'selected' : '' }}>
                {{ ucfirst($smt->semester) }} - {{ $smt->tahun }}
            </option>
        @endforeach
    </select>
    @error('id_semester')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>





        {{-- Tanggal --}}
        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal Penilaian</label>
            <input type="date" name="tanggal" id="tanggal"
                   class="form-control @error('tanggal') is-invalid @enderror"
                   value="{{ old('tanggal', $penilaian->tanggal->format('Y-m-d')) }}">
            @error('tanggal')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Nilai Kriteria --}}
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
                    min="0"
                    max="100"
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

        {{-- Tombol --}}
        <button type="submit" class="btn btn-primary">Update Penilaian</button>
        <a href="{{ route('kepsek.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
