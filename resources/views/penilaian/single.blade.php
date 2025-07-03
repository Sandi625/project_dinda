<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Penilaian</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            padding: 20px;
            color: #000;
        }

        h4, h5 {
            text-align: center;
            margin: 0;
            padding: 4px 0;
        }

        table.meta {
            width: 100%;
            margin: 15px 0;
        }

        table.meta td {
            padding: 4px;
        }

        table.observasi {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table.observasi th, table.observasi td {
            border: 1px solid #000;
            padding: 6px;
            vertical-align: top;
            text-align: center;
        }

        table.observasi td.text-left {
            text-align: left;
        }

        .sub-row td {
            padding-left: 25px;
        }

        .footer {
            margin-top: 40px;
            font-size: 11px;
            text-align: center;
            color: #666;
        }
    </style>
</head>
<body>

    <h4>Lampiran A.1 Format Observasi Kinerja Guru dalam Perencanaan</h4>
    <h5>Lembar Observasi Kinerja Guru <br> Dalam Perencanaan Pembelajaran</h5>

    <table class="meta">
        <tr><td width="180">Hari/Tanggal</td><td>: {{ \Carbon\Carbon::parse($penilaian->tanggal)->format('d-m-Y') }}</td></tr>
        <tr><td>Nama Guru</td><td>: {{ $penilaian->guru->nama ?? '-' }}</td></tr>
        <tr><td>NIP</td><td>: {{ $penilaian->guru->nip ?? '-' }}</td></tr>
        <tr><td>Mata Pelajaran</td><td>: {{ $penilaian->guru->mapel ?? '-' }}</td></tr>
        <tr><td>Nama Observer</td><td>: {{ $penilaian->user->name ?? '-' }}</td></tr>
        <tr><td>Kelas</td><td>: {{ $penilaian->guru->kelas ?? '-' }}</td></tr>
        <tr><td>Pertemuan Ke-</td><td>: {{ $penilaian->periode }}</td></tr>
    </table>

<table class="observasi" style="width: 100%; border-collapse: collapse; margin-top: 15px;">
    <thead>
        <tr style="background-color: #f0f0f0;">
            <th style="border: 1px solid #000; padding: 6px;">NO</th>
            <th style="border: 1px solid #000; padding: 6px;">Kriteria</th>
            <th style="border: 1px solid #000; padding: 6px;">Nilai</th>
        </tr>
    </thead>
    <tbody>
        @php
            $totalSkala = 0;
            $jumlahKriteria = 0;
        @endphp

        @foreach ($penilaian->detailPenilaian as $i => $detail)
            @php
                $nilai = $detail->nilai;
                if ($nilai <= 25) $skala = 0;
                elseif ($nilai <= 50) $skala = 1;
                elseif ($nilai <= 75) $skala = 2;
                else $skala = 3;

                $totalSkala += $skala;
                $jumlahKriteria++;
            @endphp
            <tr>
                <td style="border: 1px solid #000; padding: 6px; text-align: center;">{{ $i + 1 }}</td>
                <td style="border: 1px solid #000; padding: 6px;">{{ $detail->kriteria->nama }}</td>
                <td style="border: 1px solid #000; padding: 6px; text-align: center;">{{ number_format($nilai, 2) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>





@php
    $nilaiAkhir = $jumlahKriteria > 0 ? ($totalSkala / ($jumlahKriteria * 3)) * 100 : 0;

    if ($nilaiAkhir >= 85) {
        $predikat = 'A (Sangat Baik)';
    } elseif ($nilaiAkhir >= 75) {
        $predikat = 'B (Baik)';
    } elseif ($nilaiAkhir >= 65) {
        $predikat = 'C (Cukup)';
    } else {
        $predikat = 'D (Kurang)';
    }
@endphp

<table style="margin-top: 20px; width: 50%; font-size: 14px;">
    <tr>
        <td><strong>Nilai Akhir</strong></td>
        <td>: {{ number_format($nilaiAkhir, 2) }}</td>
    </tr>
    <tr>
        <td><strong>Predikat</strong></td>
        <td>: {{ $predikat }}</td>
    </tr>
</table>

{{-- TANDA TANGAN KEPALA SEKOLAH --}}
<table style="width: 100%; margin-top: 40px; text-align: center;">
    <tr>
        <td></td>
        <td>
            Mengetahui,<br>
            Kepala Sekolah<br><br>
            <img src="{{ public_path('images/Tanda_tangan_bapak.png') }}" alt="Tanda Tangan Kepala Sekolah" style="width: 120px; height: auto;"><br>
            <u><strong>Nama Kepala Sekolah</strong></u><br>
            NIP: 1234567890
        </td>
    </tr>
</table>




    <div class="footer">
        Dicetak otomatis oleh sistem pada {{ now()->format('d-m-Y H:i') }}
    </div>

</body>
</html>
