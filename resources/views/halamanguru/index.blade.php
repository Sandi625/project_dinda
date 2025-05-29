@extends('layouts.app')

@section('title', 'Dashboard Guru')

@section('content')
    <h1 class="mb-4">Daftar Penilaian dan Feedback</h1>

    @if($penilaians->count())
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>ID Penilaian</th>
                    <th>Guru</th>
                    <th>Periode</th>
                    <th>Detail Penilaian</th>
                    <th>Feedback</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($penilaians as $penilaian)
                    <tr>
                        <td>{{ $penilaian->id_penilaian }}</td>
                        <td>{{ ucwords(strtolower($penilaian->guru->nama ?? 'Tidak ada guru')) }}</td>
                        <td>{{ $penilaian->periode }}</td>
                        <td>
                            <ul class="mb-0 ps-3">
                                @foreach ($penilaian->detailPenilaian as $detail)
                                    <li>
                                        {{ $detail->kriteria->nama ?? 'Kriteria tidak ditemukan' }}:
                                        <span class="{{ $detail->nilai < 0 ? 'text-danger fw-bold' : '' }}">
                                            {{ $detail->nilai }}
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            @if($penilaian->feedback)
                                <span class="badge bg-success">{{ $penilaian->feedback->isi }}</span>
                            @else
                                <span class="badge bg-secondary">Tidak ada feedback</span>
                            @endif
                        </td>
                        <td>
                            @if(!$penilaian->feedback)
                                <a href="{{ route('halamanguru.create', ['id_penilaian' => $penilaian->id_penilaian]) }}" class="btn btn-sm btn-primary">
                                    Tambah Feedback
                                </a>
                            @else
                               <a href="{{ route('halamanguru.edit', $penilaian->feedback->id_feedback) }}" class="btn btn-sm btn-warning">
    Edit Feedback
</a>


                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-muted">Tidak ada penilaian.</p>
    @endif
@endsection
