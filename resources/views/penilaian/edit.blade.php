@extends('layouts.base')

@section('content')
<div class="container mt-4">
    <h2>Edit Penilaian</h2>

    <form action="{{ route('penilaian.update', $penilaian->id_penilaian) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="id_guru" class="form-label">Guru</label>
            <select name="id_guru" class="form-select" required>
                @foreach ($gurus as $guru)
                    <option value="{{ $guru->id_guru }}" {{ $guru->id_guru == $penilaian->id_guru ? 'selected' : '' }}>
                        {{ $guru->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="periode" class="form-label">Periode</label>
            <input type="text" name="periode" class="form-control" value="{{ $penilaian->periode }}" required>
        </div>

        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" value="{{ $penilaian->tanggal }}" required>
        </div>

        <h5>Detail Penilaian</h5>
        <div id="detail-penilaian">
            @foreach ($kriterias as $kriteria)
                @php
                    $nilai = $penilaian->detailPenilaian->firstWhere('id_kriteria', $kriteria->id_kriteria);
                @endphp
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">{{ $kriteria->nama_kriteria }}</label>
                        <input type="hidden" name="detail[{{ $loop->index }}][id_kriteria]" value="{{ $kriteria->id_kriteria }}">
                        <input type="number" name="detail[{{ $loop->index }}][nilai]" class="form-control" value="{{ $nilai ? $nilai->nilai : '' }}" placeholder="Nilai" required>
                    </div>
                </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
