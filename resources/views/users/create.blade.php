@extends('layouts.base')

@section('title', 'Tambah User')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Tambah User</h1>

    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                    @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label>Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>

            <div class="form-group">
    <label>Role</label>
    <select name="role" class="form-control" required>
        <option value="">-- Pilih Role --</option>
        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
        <option value="guru" {{ old('role') == 'guru' ? 'selected' : '' }}>Guru</option>
        <option value="kepala_sekolah" {{ old('role') == 'kepala_sekolah' ? 'selected' : '' }}>Kepala Sekolah</option>
    </select>
    @error('role') <small class="text-danger">{{ $message }}</small> @enderror
</div>


                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
