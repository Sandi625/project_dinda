@extends('layouts.base')

@section('content')
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header">
            <h3 class="mb-0">Tambah Guru</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('guru.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="id_user" class="form-label">User</label>
                    <select name="id_user" id="id_user" class="form-select" required>
                        <option value="">-- Pilih User --</option>
                        @foreach ($users as $u)
                            <option value="{{ $u->id_user }}">{{ $u->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="nip" class="form-label">NIP</label>
                    <input type="text" name="nip" id="nip" class="form-control" placeholder="Masukkan NIP" value="{{ old('nip') }}">
                </div>

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukkan Nama" value="{{ old('nama') }}" required>
                </div>

                <div class="mb-3">
    <label for="periode_mulai" class="form-label">Periode Mulai</label>
    <input type="number" class="form-control" name="periode_mulai" value="{{ old('periode_mulai', $guru->periode_mulai ?? '') }}" placeholder="Contoh: 2023">
</div>
<div class="mb-3">
    <label for="periode_selesai" class="form-label">Periode Selesai</label>
    <input type="number" class="form-control" name="periode_selesai" value="{{ old('periode_selesai', $guru->periode_selesai ?? '') }}" placeholder="Contoh: 2024">
</div>


                {{-- Ganti input text mapel menjadi dropdown id_mapel --}}
                <div class="mb-3">
                    <label for="id_mapel" class="form-label">Mata Pelajaran</label>
                    <select name="id_mapel" id="id_mapel" class="form-select">
                        <option value="">-- Pilih Mapel --</option>
                        @foreach ($mapel as $m)
                            <option value="{{ $m->id }}" {{ old('id_mapel') == $m->id ? 'selected' : '' }}>
                                {{ $m->nama_mapel }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea name="alamat" id="alamat" rows="3" class="form-control" placeholder="Masukkan Alamat">{{ old('alamat') }}</textarea>
                </div>

                <button type="submit" class="btn btn-success">Simpan</button>
                <a href="{{ route('guru.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
