@extends('layouts.base')

@section('title', 'Edit User')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Edit User</h1>

    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('users.update', $user->id_user) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label>Password Baru (Kosongkan jika tidak diubah)</label>
                    <input type="password" name="password" class="form-control">
                    @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label>Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>

                <div class="form-group">
                    <label>Role</label>
                    <select name="role" class="form-control" required>
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
<option value="guru" {{ $user->role == 'guru' ? 'selected' : '' }}>Guru</option>
<option value="kepala_sekolah" {{ $user->role == 'kepala_sekolah' ? 'selected' : '' }}>Kepala Sekolah</option>
                    </select>
                    @error('role') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
