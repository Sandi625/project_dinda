@extends('layouts.base')

@section('content')
<div class="container mt-4">
    <h2>Edit Penilaian</h2>

    <form action="{{ route('penilaian.update', $penilaian->id_penilaian) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Guru --}}
        <div class="mb-3">
            <label for="id_guru" class="form-label">Guru</label>
            <select name="id_guru" class="form-select" required>
                <option value="">-- Pilih Guru --</option>
                @foreach ($gurus as $guru)
                    <option value="{{ $guru->id_guru }}"
                        {{ old('id_guru', $penilaian->id_guru) == $guru->id_guru ? 'selected' : '' }}>
                        {{ $guru->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- User Pembuat --}}
        <div class="mb-3">
            <label for="id_user" class="form-label">User Pembuat</label>
            <select name="id_user" class="form-select" required>
                <option value="">-- Pilih User --</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id_user }}"
                        {{ old('id_user', $penilaian->id_user) == $user->id_user ? 'selected' : '' }}>
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
                    <option value="{{ $k->id }}"
                        {{ old('id_kelas', $penilaian->id_kelas) == $k->id ? 'selected' : '' }}>
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
                    <option value="{{ $mapel->id }}"
                        {{ old('id_mapel', $penilaian->id_mapel) == $mapel->id ? 'selected' : '' }}>
                        {{ $mapel->nama_mapel }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Semester --}}
      <div class="mb-3">
    <label for="id_semester" class="form-label">Semester</label>
    <select name="id_semester" id="id_semester" class="form-select" required>
        <option value="">-- Pilih Semester --</option>
        @foreach ($semesters as $s)
            <option value="{{ $s->id }}" {{ old('id_semester', $penilaian->id_semester) == $s->id ? 'selected' : '' }}>
                {{ ucfirst($s->semester) }} - {{ $s->tahun }}
            </option>
        @endforeach
    </select>
</div>


        {{-- Tanggal --}}
        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" name="tanggal" class="form-control"
                value="{{ old('tanggal', \Carbon\Carbon::parse($penilaian->tanggal)->format('Y-m-d')) }}" required>
        </div>

        {{-- Detail Penilaian --}}
        <h5>Detail Penilaian</h5>
        <div id="detail-penilaian">
            @foreach ($kriterias as $kriteria)
                @php
                    $nilai = $penilaian->detailPenilaian->firstWhere('id_kriteria', $kriteria->id_kriteria);
                @endphp
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">{{ $kriteria->nama_kriteria }}</label>
                        <input type="hidden" name="detail[{{ $loop->index }}][id_kriteria]" value="{{ $kriteria->id_kriteria }}">
                        <input type="number" name="detail[{{ $loop->index }}][nilai]" class="form-control"
                            placeholder="Nilai"
                            value="{{ old("detail.$loop->index.nilai", $nilai ? $nilai->nilai : '') }}"
                            required min="0" max="100">
                    </div>
                </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
