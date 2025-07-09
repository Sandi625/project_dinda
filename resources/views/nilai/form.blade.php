@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h4>Input Nilai Siswa</h4>
    <p><strong>Kelas:</strong> {{ $kelas->nama_kelas }} | <strong>Mapel:</strong> {{ $mapel->nama_mapel }}</p>

    <form action="{{ route('beri-nilai.simpan') }}" method="POST">
        @csrf

        <table class="table table-bordered">
            <thead class="table-secondary">
                <tr>
                    <th>No</th>
                    <th>Nama Siswa</th>
                    <th>NIS</th>
                    <th>Nilai</th>
                </tr>
            </thead>
            <tbody>
                @foreach($siswa as $index => $s)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $s->nama }}</td>
                        <td>{{ $s->nis }}</td>
                        <td>
                            <input type="number" name="nilai[{{ $s->id }}]" class="form-control" value="{{ old('nilai.' . $s->id, $s->nilai) }}" min="0" max="100">
                        </td>
                    </tr>
                @endforeach

                @if($siswa->isEmpty())
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada siswa ditemukan.</td>
                    </tr>
                @endif
            </tbody>
        </table>

        @if(!$siswa->isEmpty())
            <button type="submit" class="btn btn-success">Simpan Nilai</button>
        @endif

        <a href="{{ route('beri-nilai.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
