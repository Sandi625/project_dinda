@extends('layouts.base')

@section('content')
<div class="container">
    <h2>Edit Jadwal Mengajar</h2>

    {{-- Error Message --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Oops!</strong> Ada beberapa kesalahan input:
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Flash Success --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('jadwal.update', $jadwal->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Guru --}}
        <div class="mb-3">
            <label for="id_guru" class="form-label">Guru</label>
            <select name="id_guru" class="form-select" required>
                <option value="">-- Pilih Guru --</option>
                @foreach ($gurus as $guru)
                    <option value="{{ $guru->id_guru }}" {{ old('id_guru', $jadwal->id_guru) == $guru->id_guru ? 'selected' : '' }}>
                        {{ $guru->nama }}
                    </option>
                @endforeach
            </select>
            @error('id_guru')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- Akun --}}
        <div class="mb-3">
            <label for="id_user" class="form-label">Akun</label>
            <select name="id_user" class="form-select" required>
                <option value="">-- Pilih Akun --</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id_user }}" {{ old('id_user', $jadwal->id_user) == $user->id_user ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
            @error('id_user')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- Mapel --}}
        <div class="mb-3">
            <label for="id_mapel" class="form-label">Mata Pelajaran</label>
            <select name="id_mapel" class="form-select" required>
                <option value="">-- Pilih Mapel --</option>
                @foreach ($mapels as $mapel)
                    <option value="{{ $mapel->id }}" {{ old('id_mapel', $jadwal->id_mapel) == $mapel->id ? 'selected' : '' }}>
                        {{ $mapel->nama_mapel }}
                    </option>
                @endforeach
            </select>
            @error('id_mapel')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- Kelas --}}
        <div class="mb-3">
            <label for="id_kelas" class="form-label">Kelas</label>
            <select name="id_kelas" class="form-select" required>
                <option value="">-- Pilih Kelas --</option>
                @foreach ($kelas as $kls)
                    <option value="{{ $kls->id }}" {{ old('id_kelas', $jadwal->id_kelas) == $kls->id ? 'selected' : '' }}>
                        {{ $kls->nama_kelas }}
                    </option>
                @endforeach
            </select>
            @error('id_kelas')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- Hari --}}
        <div class="mb-3">
            <label for="hari" class="form-label">Hari</label>
            <select name="hari" class="form-select" required>
                <option value="">-- Pilih Hari --</option>
                @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $hari)
                    <option value="{{ $hari }}" {{ old('hari', $jadwal->hari) == $hari ? 'selected' : '' }}>
                        {{ $hari }}
                    </option>
                @endforeach
            </select>
            @error('hari')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- Jam ke --}}
        @php
            $jamMapping = [
                1 => '07:00 - 07:45',
                2 => '07:45 - 08:30',
                3 => '08:30 - 09:15',
                4 => '09:15 - 10:00',
                5 => '10:20 - 11:05',
                6 => '11:05 - 11:50',
                7 => '12:30 - 13:10',
                8 => '13:10 - 13:50',
                9 => '13:50 - 14:30',
                10 => '14:30 - 15:10',
            ];
        @endphp

        <div class="mb-3">
            <label for="jam_ke" class="form-label">Jam ke</label>
            <select name="jam_ke" class="form-select" required>
                <option value="">-- Pilih Jam ke --</option>
                @foreach ($jamMapping as $jamKe => $rentang)
                    <option value="{{ $jamKe }}" {{ old('jam_ke', $jadwal->jam_ke) == $jamKe ? 'selected' : '' }}>
                        Jam ke-{{ $jamKe }} ({{ $rentang }})
                    </option>
                @endforeach
            </select>
            @error('jam_ke')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('jadwal.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
