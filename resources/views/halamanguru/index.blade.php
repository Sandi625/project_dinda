@extends('layouts.app')

@section('title', 'Dashboard Guru')

@section('content')
    <h1 class="mb-4">Daftar Penilaian dan Feedback</h1>

    @if ($penilaians->count())
        @foreach ($penilaians as $index => $penilaian)
            <div class="mb-5">
                <h5 class="mb-3">Penilaian #{{ $index + 1 }}</h5>
                <table class="table table-bordered">
                    <thead class="table-success">
                        <tr>
                            <th>ID User</th>
                            <th>User</th>
                            <th>Semester</th>
                            <th>Detail Penilaian</th>
                            <th>Komentar Kepala Sekolah</th>
                            <th>Feedback Guru</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @if ($penilaian->feedbacks->isNotEmpty())
                            @foreach ($penilaian->feedbacks as $fb)
                                <tr>
                                    <td>{{ $penilaian->id_user }}</td>
                                    <td>{{ ucwords(strtolower(optional($penilaian->user)->name ?? 'Tidak ada user')) }}</td>
                                    <td>
                                        @if ($penilaian->semester)
                                            {{ dd($penilaian->semester) }}
                                            Semester: {{ ucfirst($penilaian->semester->semester) }}<br>
                                            Tahun: {{ $penilaian->semester->tahun }}
                                        @else
                                            <span class="text-danger">Semester tidak tersedia</span>
                                        @endif
                                    </td>



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
                                        <span class="badge bg-success d-block mb-1">{{ $fb->isi ?? 'Belum ada' }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="badge bg-info d-block mb-1">{{ $fb->feedback_guru ?? 'Belum diisi' }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('halamanguru.edit', $fb->id_feedback) }}"
                                            class="btn btn-sm btn-warning d-block">
                                            Edit Feedback
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td>{{ $penilaian->id_user }}</td>
                                <td>{{ ucwords(strtolower(optional($penilaian->user)->name ?? 'Tidak ada user')) }}</td>
                                <td>
                                    ID: {{ optional($penilaian->semester)->id ?? '-' }}<br>
                                    Semester: {{ ucfirst(optional($penilaian->semester)->semester ?? '-') }}<br>
                                    Tahun: {{ optional($penilaian->semester)->tahun ?? '-' }}
                                </td>
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
                                <td><span class="badge bg-secondary">Belum ada</span></td>
                                <td><span class="badge bg-secondary">Belum ada</span></td>
                                <td>
                                    <a href="{{ route('halamanguru.create', ['id_penilaian' => $penilaian->id_penilaian]) }}"
                                        class="btn btn-sm btn-primary">
                                        Tambah Feedback
                                    </a>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>


            </div>
        @endforeach
    @else
        <p class="text-muted">Tidak ada penilaian.</p>
    @endif
@endsection
