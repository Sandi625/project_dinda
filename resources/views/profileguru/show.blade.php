@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Profil Guru</h3>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header bg-light fw-bold">
            Informasi Akun
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Nama</div>
                <div class="col-md-9">{{ $user->name }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Email</div>
                <div class="col-md-9">{{ $user->email }}</div>
            </div>
            <div class="row mb-4">
                <div class="col-md-3 fw-bold">Role</div>
                <div class="col-md-9 text-uppercase">
                    <span class="badge bg-info">{{ $user->role }}</span>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('guru.profile.edit') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-edit me-1"></i> Edit Profil
                </a>
                {{-- <a href="{{ route('guru.profile.password.edit') }}" class="btn btn-sm btn-warning">
                    <i class="fas fa-key me-1"></i> Ubah Password
                </a> --}}
            </div>
        </div>
    </div>
</div>
@endsection
