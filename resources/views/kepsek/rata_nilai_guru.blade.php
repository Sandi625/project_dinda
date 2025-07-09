@extends('layouts.master')

@section('content')
<div class="container mt-4">
    <h3>Rata-rata Nilai Siswa per Guru</h3>

    <table class="table table-bordered table-striped mt-3">
        <thead class="table-light">
            <tr>
                <th>No</th>
                <th>Nama Guru</th>
                <th>Mapel</th>
                <th>Jumlah Siswa</th>
                <th>Rata-rata Nilai</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item['guru']->nama }}</td>
                    <td>{{ $item['mapel'] }}</td>
                    <td>{{ $item['jumlah_siswa'] }}</td>
                    <td>
                        @if(is_numeric($item['rata_nilai']))
                            {{ $item['rata_nilai'] }}
                        @else
                            <span class="text-muted">{{ $item['rata_nilai'] }}</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Belum ada data guru.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
