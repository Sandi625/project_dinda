@extends('layouts.master')

@section('content')
<div class="container mt-4">
    <h2>Tambah Penilaian</h2>

    <form action="{{ route('kepsek.store') }}" method="POST">
        @csrf

        {{-- Guru --}}

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

  <div class="mb-3">
    <label for="id_guru" class="form-label">Guru</label>
    <select name="id_guru" id="id_guru" class="form-select" required>
        <option value="">-- Pilih Guru --</option>
        @foreach ($gurus as $guru)
            <option value="{{ $guru->id_guru }}">{{ $guru->nama }}</option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label for="mapel" class="form-label">Mata Pelajaran</label>
    <select name="id_mapel" id="mapel" class="form-select" required>
        <option value="">-- Pilih Mapel --</option>
    </select>
</div>

<div class="mb-3">
    <label for="kelas" class="form-label">Kelas</label>
    <select name="id_kelas" id="kelas" class="form-select" required>
        <option value="">-- Pilih Kelas --</option>
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
    document.querySelector('select[name="id_guru"]').addEventListener('change', function () {
        const guruId = this.value;
        const mapelSelect = document.getElementById('mapel');
        const kelasSelect = document.getElementById('kelas');

        mapelSelect.innerHTML = '<option value="">-- Pilih Mapel --</option>';
        kelasSelect.innerHTML = '<option value="">-- Pilih Kelas --</option>';

        if (guruId) {
            fetch(`/penilaian/get-mapel-kelas/${guruId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.mapel && data.mapel.id) {
                        const option = document.createElement('option');
                        option.value = data.mapel.id;
                        option.textContent = data.mapel.nama_mapel;
                        mapelSelect.appendChild(option);
                    }

                    if (data.kelas && data.kelas.id) {
                        const option = document.createElement('option');
                        option.value = data.kelas.id;
                        option.textContent = data.kelas.nama_kelas;
                        kelasSelect.appendChild(option);
                    }
                })
                .catch(error => console.error('Gagal ambil data:', error));
        }
    });
</script>






@endsection
