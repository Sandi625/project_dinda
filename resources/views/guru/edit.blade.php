@extends('layouts.base')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header" style="background-color: var(--bs-primary-bg-subtle);">
            <h4 class="mb-0">Edit Guru</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('guru.update', $guru->id_guru) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="id_user" class="form-label">User</label>
                    <select name="id_user" id="id_user" class="form-select" required>
                        @foreach ($users as $u)
                            <option value="{{ $u->id_user }}" {{ $u->id_user == $guru->id_user ? 'selected' : '' }}>
                                {{ $u->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="nip" class="form-label">NIP</label>
                    <input type="text" name="nip" id="nip" class="form-control" value="{{ old('nip', $guru->nip) }}">
                </div>

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama', $guru->nama) }}" required>
                </div>
                <div class="mb-3">
    <label for="periode_mulai" class="form-label">Periode Mulai</label>
    <input type="number" class="form-control" name="periode_mulai" value="{{ old('periode_mulai', $guru->periode_mulai ?? '') }}" placeholder="Contoh: 2023">
</div>
<div class="mb-3">
    <label for="periode_selesai" class="form-label">Periode Selesai</label>
    <input type="number" class="form-control" name="periode_selesai" value="{{ old('periode_selesai', $guru->periode_selesai ?? '') }}" placeholder="Contoh: 2024">
</div>


                {{-- Ubah input teks mapel menjadi dropdown relasi ke id_mapel --}}
                <div class="mb-3">
                    <label for="id_mapel" class="form-label">Mata Pelajaran</label>
                    <select name="id_mapel" id="id_mapel" class="form-select">
                        <option value="">-- Pilih Mapel --</option>
                        @foreach ($mapel as $m)
                            <option value="{{ $m->id }}" {{ $guru->id_mapel == $m->id ? 'selected' : '' }}>
                                {{ $m->nama_mapel }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea name="alamat" id="alamat" class="form-control" rows="3">{{ old('alamat', $guru->alamat) }}</textarea>
                </div>

                <button type="submit" class="btn btn-success">Update</button>
                <a href="{{ route('guru.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
