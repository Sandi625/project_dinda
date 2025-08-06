@extends('layouts.master')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Laporan Kinerja Guru</h3>
    <a href="{{ route('kepsek.index') }}" class="btn btn-primary mb-3">
    <i class="bi bi-arrow-left"></i> Ke halaman penilaian
</a>


<form method="GET" action="{{ route('kepsek.laporan_kinerja') }}" class="mb-3">
    <div class="row">
        <div class="col-md-4">
            <label for="semester" class="form-label">Pilih Semester</label>
            <select name="id_semester" id="semester" class="form-select" onchange="this.form.submit()">
                <option value="">-- Filter Semester --</option>
                @foreach ($daftarSemester as $smt)
                    <option value="{{ $smt->id }}" {{ request('id_semester') == $smt->id ? 'selected' : '' }}>
                        {{ ucfirst($smt->semester) }} {{ $smt->tahun }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</form>




    @if ($laporanKinerja->count())
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Guru</th>
                    <th>Semester</th>
                    <th>Tanggal Dibuat</th>
                    <th>Indikator</th>
                    <th>Bukti</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($laporanKinerja as $index => $laporan)
                    @php
                        $detailCount = $laporan->detail->count();
                        $rowspan = $detailCount > 0 ? $detailCount : 1;
                    @endphp

                    @if ($detailCount > 0)
                        @foreach ($laporan->detail as $i => $detail)
                            <tr>
                                @if ($i === 0)
                                    <td rowspan="{{ $rowspan }}">{{ $index + 1 }}</td>
                                    <td rowspan="{{ $rowspan }}">{{ $laporan->guru->user->name ?? '-' }}</td>
                                    <td rowspan="{{ $rowspan }}">{{ ucfirst($detail->semester) }}</td>
                                    <td rowspan="{{ $rowspan }}">{{ $laporan->created_at->format('d M Y') }}</td>
                                @endif
                                <td>{{ $detail->indikator }}</td>
                                <td>
                                    @if ($detail->file_bukti)
                                        <a href="{{ asset('storage/' . $detail->file_bukti) }}" target="_blank">Lihat Bukti</a>
                                    @else
                                        <span class="text-muted">Tidak ada</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $laporan->guru->user->name ?? '-' }}</td>
                            <td class="text-muted">-</td>
                            <td>{{ $laporan->created_at->format('d M Y') }}</td>
                            <td colspan="2" class="text-muted">Belum ada indikator</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-info">
            Belum ada laporan kinerja tersedia.
        </div>
    @endif
</div>
@endsection
