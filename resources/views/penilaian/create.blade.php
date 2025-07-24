@extends('layouts.base')

@section('content')
<div class="container mt-4">
    <h2>Tambah Penilaian</h2>

    <form action="{{ route('penilaian.store') }}" method="POST">
        @csrf

        {{-- Guru --}}
        <div class="mb-3">
            <label for="id_guru" class="form-label">Guru</label>
            <select name="id_guru" class="form-select" required>
                <option value="">-- Pilih Guru --</option>
                @foreach ($gurus as $guru)
                    <option value="{{ $guru->id_guru }}" {{ old('id_guru') == $guru->id_guru ? 'selected' : '' }}>
                        {{ $guru->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- User Pembuat --}}
        <div class="mb-3">
            <label for="id_user" class="form-label">Beri Akun (agar bisa Login dan melihat nilai)</label>
            <select name="id_user" class="form-select" required>
                <option value="">-- Pilih User --</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id_user }}" {{ old('id_user') == $user->id_user ? 'selected' : '' }}>
                        {{ $user->name }} ({{ $user->role }})
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Kelas --}}
        <div class="mb-3">
            <label for="id_kelas" class="form-label">Kelas</label>
            <select name="id_kelas" class="form-select" required>
                <option value="">-- Pilih Kelas --</option>
                @foreach ($kelas as $k)
                    <option value="{{ $k->id }}" {{ old('id_kelas') == $k->id ? 'selected' : '' }}>
                        {{ $k->nama_kelas }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Mapel --}}
        <div class="mb-3">
            <label for="id_mapel" class="form-label">Mata Pelajaran</label>
            <select name="id_mapel" class="form-select" required>
                <option value="">-- Pilih Mata Pelajaran --</option>
                @foreach ($mapels as $mapel)
                    <option value="{{ $mapel->id }}" {{ old('id_mapel') == $mapel->id ? 'selected' : '' }}>
                        {{ $mapel->nama_mapel }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Semester --}}
        <div class="mb-3">
            <label for="semester" class="form-label">Semester</label>
            <select name="semester" id="semester" class="form-select" required>
                <option value="">-- Pilih Semester --</option>
                @foreach ($daftarSemester as $s)
                    <option value="{{ $s }}" {{ old('semester') == $s ? 'selected' : '' }}>
                        {{ ucfirst($s) }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Tanggal --}}
        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal') }}" required>
        </div>

        {{-- Detail Penilaian --}}
        <h5>Detail Penilaian</h5>
        <div id="detail-penilaian">
            @foreach ($kriterias as $kriteria)
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">{{ $kriteria->nama }}</label>
                        <input type="hidden" name="detail[{{ $loop->index }}][id_kriteria]" value="{{ $kriteria->id_kriteria }}">
                        <input type="number" name="detail[{{ $loop->index }}][nilai]" class="form-control" placeholder="Nilai" required min="0" max="100" step="1" value="{{ old("detail.{$loop->index}.nilai") }}">
                    </div>
                </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
