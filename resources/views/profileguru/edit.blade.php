@extends('layouts.app')

@section('title', 'Edit Profil Guru')

@section('content')
<div class="container mt-4">
    <h4 class="mb-4">Edit Profil Guru</h4>

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    {{-- Error Message --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form Update Profil --}}
    <form action="{{ route('guru.profile.update') }}" method="POST" class="mb-5">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        <a href="{{ route('guru.profile.show') }}" class="btn btn-secondary">Batal</a>
    </form>

    <hr>

    {{-- Form Ubah Password --}}
    <h5 class="mb-3">Ubah Password</h5>

    <form action="{{ route('guru.profile.password.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="password_lama" class="form-label">Password Lama</label>
            <input type="password" name="password_lama" class="form-control" required autocomplete="off">
            @error('password_lama') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="password_baru" class="form-label">Password Baru</label>
            <input type="password" name="password_baru" class="form-control" required>
            @error('password_baru') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="password_baru_confirmation" class="form-label">Konfirmasi Password Baru</label>
            <input type="password" name="password_baru_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-warning">Ubah Password</button>
    </form>
</div>
@endsection
