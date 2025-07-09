<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Penilaian Administrasi</title>
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

        table.komponen {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table.komponen th, table.komponen td {
            border: 1px solid #000;
            padding: 6px;
            vertical-align: top;
            text-align: center;
        }

        table.komponen td.text-left {
            text-align: left;
        }

        .highlight {
            font-weight: bold;
            background-color: #eaeaea;
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

    <h4>Lampiran A.2 Format Penilaian Administrasi Pembelajaran</h4>
    <h5>Instrumen Penilaian Administrasi Guru</h5>

    <table class="meta">
        <tr><td width="180">Hari/Tanggal</td><td>: {{ \Carbon\Carbon::parse($penilaian->tanggal)->format('d-m-Y') }}</td></tr>
        <tr><td>Nama Guru</td><td>: {{ $penilaian->guru->nama ?? '-' }}</td></tr>
        <tr><td>NIP</td><td>: {{ $penilaian->guru->nip ?? '-' }}</td></tr>
        <tr><td>Mata Pelajaran</td><td>: {{ $penilaian->guru->mapel->nama_mapel ?? '-' }}</td></tr>
        <tr><td>Nama Observer</td><td>: {{ $penilaian->user->name ?? '-' }}</td></tr>
        <tr><td>Kelas</td><td>: {{ $penilaian->guru->kelas->nama_kelas ?? '-' }}</td></tr>
        <tr><td>Periode</td><td>: {{ $penilaian->periode }}</td></tr>
    </table>

    <table class="komponen" style="width: 100%; border-collapse: collapse;" border="1" cellpadding="5">
        <thead style="background-color: #f0f0f0;">
            <tr>
                <th width="30">NO</th>
                <th class="text-left">Komponen Administrasi Pembelajaran</th>
                <th width="80">Maksimal</th>
                <th width="80">Perolehan</th>
                <th width="120">Keterangan</th>
            </tr>
        </thead>
        <tbody>
        @php
            $totalNilai = 0;
            $jumlahKriteria = $penilaian->detailPenilaian->count();
        @endphp

        @foreach ($penilaian->detailPenilaian as $i => $detail)
            @php
                $nilai = $detail->nilai ?? 0;
                $totalNilai += $nilai;
            @endphp
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $detail->kriteria->nama ?? '-' }}</td>
                <td>100</td>
                <td>{{ number_format($nilai, 2) }}</td>
                <td></td>
            </tr>
        @endforeach

        <tr style="font-weight: bold;">
            <td colspan="2">Jumlah Skor Penilaian</td>
            <td>{{ $jumlahKriteria * 100 }}</td>
            <td>{{ number_format($totalNilai, 2) }}</td>
            <td></td>
        </tr>
        </tbody>
    </table>

    @php
        $nilaiAkhir = $jumlahKriteria > 0 ? ($totalNilai / $jumlahKriteria) : 0;

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

    <table style="width: 100%; margin-top: 60px; text-align: center;">
        <tr>
            <td></td>
            <td>
                Mengetahui,<br>
                Kepala Sekolah<br><br>
                <img src="{{ public_path('images/Tanda_tangan_bapak.png') }}" alt="Tanda Tangan Kepala Sekolah" style="width: 120px;"><br>
                <u><strong>Nama Kepala Sekolah</strong></u><br>
                NIP: 1234567890
            </td>
        </tr>
    </table>

    <div class="footer" style="position: fixed; bottom: 30px; font-size: 12px; width: 100%; text-align: center;">
        Dicetak otomatis oleh sistem pada {{ now()->format('d-m-Y H:i') }}
    </div>

</body>

</html>
