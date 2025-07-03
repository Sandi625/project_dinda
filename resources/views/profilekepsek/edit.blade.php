@extends('layouts.master')

@section('title', 'Edit Profil')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Edit Profil</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('kepsek.profile.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Nama</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        <a href="{{ route('kepsek.profile.show') }}" class="btn btn-secondary">Batal</a>
    </form>

    <hr>

    <h4>Ubah Password</h4>

    <form action="{{ route('kepsek.profile.password.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="current_password">Password Lama</label>
            <input type="password" name="current_password" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="new_password">Password Baru</label>
            <input type="password" name="new_password" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="new_password_confirmation">Konfirmasi Password Baru</label>
            <input type="password" name="new_password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-warning">Ubah Password</button>
    </form>
</div>
@endsection
