@extends('layouts.base')

@section('title', 'Profil Saya')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Profil Saya</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Tutup">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow-sm border-left-primary">
        <div class="card-header bg-white font-weight-bold">
            Informasi Akun
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-3 font-weight-bold text-gray-700">Nama</div>
                <div class="col-md-9">{{ $user->name }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 font-weight-bold text-gray-700">Email</div>
                <div class="col-md-9">{{ $user->email }}</div>
            </div>
            <div class="row mb-4">
                <div class="col-md-3 font-weight-bold text-gray-700">Role</div>
                <div class="col-md-9 text-uppercase">
                    <span class="badge badge-info">{{ $user->role }}</span>
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-edit mr-1"></i> Edit Profil
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
