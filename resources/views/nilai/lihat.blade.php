@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Lihat Nilai Siswa</h3>
    <form action="{{ route('beri-nilai.hasil') }}" method="POST">
        @csrf
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="id_kelas" class="form-label">Kelas</label>
                <select name="id_kelas" id="id_kelas" class="form-control" required>
                    <option value="">Pilih Kelas</option>
                    @foreach($kelas as $k)
                        <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label for="id_mapel" class="form-label">Mapel</label>
                <select name="id_mapel" id="id_mapel" class="form-control" required>
                    <option value="">Pilih Mapel</option>
                    @foreach($mapel as $m)
                        <option value="{{ $m->id }}">{{ $m->nama_mapel }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <button class="btn btn-primary">Lihat Nilai</button>
    </form>
</div>
@endsection
