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
                    <input type="text" name="nip" id="nip" class="form-control" value="{{ $guru->nip }}" required>
                </div>

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" name="nama" id="nama" class="form-control" value="{{ $guru->nama }}" required>
                </div>

                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea name="alamat" id="alamat" class="form-control" rows="3" required>{{ $guru->alamat }}</textarea>
                </div>

                <button type="submit" class="btn btn-success">Update</button>
                <a href="{{ route('guru.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
