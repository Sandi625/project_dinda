@extends('layouts.master')

@section('content')
<div class="container mt-4">
    <h2>Tambah Penilaian</h2>

    <form action="{{ route('kepsek.store') }}" method="POST">
        @csrf

     {{-- User --}}
<div class="mb-3">
    <label for="id_user" class="form-label">Beri Akun (agar bisa Login dan melihat nilai)</label>
    <select name="id_user" id="id_user" class="form-select" required>
        <option value="">-- Pilih User --</option>
        @foreach ($users as $user)
            <option value="{{ $user->id_user }}" {{ old('id_user') == $user->id_user ? 'selected' : '' }}>
                {{ $user->name }} ({{ $user->role }})
            </option>
        @endforeach
    </select>
</div>

{{-- Guru --}}
<div class="mb-3">
    <label for="id_guru" class="form-label">Guru</label>
    <select name="id_guru" id="id_guru" class="form-select" required>
        <option value="">-- Pilih Guru --</option>
        @foreach ($gurus as $guru)
            <option value="{{ $guru->id_guru }}" data-id_user="{{ $guru->id_user }}">
                {{ $guru->nama }}
            </option>
        @endforeach
    </select>
</div>

        {{-- Mapel --}}
        <div class="mb-3">
            <label for="id_mapel" class="form-label">Mata Pelajaran</label>
            <select name="id_mapel" id="id_mapel" class="form-select" required>
                <option value="">-- Pilih Mapel --</option>
                @foreach ($mapels as $mapel)
                    <option value="{{ $mapel->id }}">{{ $mapel->nama_mapel }}</option>
                @endforeach
            </select>
        </div>

        {{-- Kelas --}}
        <div class="mb-3">
            <label for="id_kelas" class="form-label">Kelas</label>
            <select name="id_kelas" id="id_kelas" class="form-select" required>
                <option value="">-- Pilih Kelas --</option>
                @foreach ($kelas as $k)
                    <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                @endforeach
            </select>
        </div>

        {{-- Semester --}}
        <div class="mb-3">
            <label for="id_semester" class="form-label">Semester</label>
            <select name="id_semester" id="id_semester" class="form-select" required>
                <option value="">-- Pilih Semester --</option>
                @foreach ($semesters as $s)
                    <option value="{{ $s->id }}" {{ old('id_semester', $penilaian->id_semester ?? '') == $s->id ? 'selected' : '' }}>
                        {{ ucfirst($s->semester) }} - {{ $s->tahun }}
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

<script>
document.getElementById('id_user').addEventListener('change', function() {
    const selectedUserId = this.value;
    const guruSelect = document.getElementById('id_guru');
    let found = false;

    for (let option of guruSelect.options) {
        if (option.getAttribute('data-id_user') === selectedUserId) {
            option.selected = true;
            found = true;
            break;
        }
    }

    if (!found) {
        guruSelect.value = ""; // reset jika tidak ada guru yg cocok
    }
});
</script>
@endsection
