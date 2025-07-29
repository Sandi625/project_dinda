<!DOCTYPE html>
<html>
<head>
  <title>Instrumen Supervisi Administrasi Pembelajaran</title>
  <style>
    body {
      font-family: Arial, sans-serif;
    }

    h3 {
      text-align: center;
      margin-bottom: 10px;
    }

    .form-info {
      margin-bottom: 15px;
    }

    .form-info p {
      margin: 4px 0;
    }

    .form-info strong {
      display: inline-block;
      width: 160px;
    }

    .garis {
      display: inline-block;
      border-bottom: 1px solid #000;
      min-width: 250px;
      padding-bottom: 2px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }

    th, td {
      border: 1px solid #000;
      padding: 6px;
      text-align: center;
    }

    th {
      background-color: #f2f2f2;
    }

    .text-left {
      text-align: left;
    }
  </style>
</head>
<body>

<h3>INSTRUMEN SUPERVISI ADMINISTRASI PEMBELAJARAN</h3>

<div class="form-info">
  <p><strong>Nama Sekolah:</strong> <span class="garis">SMK MUHAMMADIYAH 9 GAMBARAN</span></p>
  <p><strong>Nama Guru:</strong> <span class="garis">{{ $penilaian->guru->nama ?? '-' }}</span></p>
  <p><strong>Elemen / Mapel:</strong> <span class="garis">{{ $penilaian->guru->mapel->nama_mapel ?? '-' }}</span></p>
  <p><strong>Semester / Kelas:</strong> <span class="garis">{{ $penilaian->guru->kelas->nama_kelas ?? '-' }}</span></p>
  <p><strong>Hari / Tanggal:</strong> <span class="garis">{{ \Carbon\Carbon::parse($penilaian->tanggal)->translatedFormat('l, d F Y') }}</span></p>
</div>

<table>
  <thead>
    <tr>
      <th>No</th>
      <th class="text-left">Komponen Administrasi Pembelajaran</th>
      <th>Penilaian Maksimal</th>
      <th>Skor Perolehan</th>
      <th>Keterangan</th>
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
        <td class="text-left">{{ $detail->kriteria->nama ?? '-' }}</td>
        <td>5</td>
        <td>{{ number_format($nilai, 2) }}</td>
        <td></td>
      </tr>
    @endforeach

    <tr style="font-weight: bold; background-color: #f9f9f9;">
      <td colspan="2" class="text-left">Jumlah Skor Penilaian</td>
      <td>{{ $jumlahKriteria * 5 }}</td>
      <td>{{ number_format($totalNilai, 2) }}</td>
      <td></td>
    </tr>
    <tr style="font-weight: bold; background-color: #f9f9f9;">
      <td colspan="2" class="text-left">Nilai Akhir = (Skor ÷ {{ $jumlahKriteria * 5 }}) × 100</td>
      <td colspan="2">
        @php
          $nilaiAkhir = $jumlahKriteria > 0 ? ($totalNilai / ($jumlahKriteria * 5)) * 100 : 0;
          $predikat = '-';
          if ($nilaiAkhir >= 85) $predikat = 'A (Sangat Baik)';
          elseif ($nilaiAkhir >= 75) $predikat = 'B (Baik)';
          elseif ($nilaiAkhir >= 65) $predikat = 'C (Cukup)';
          else $predikat = 'D (Kurang)';
        @endphp
        {{ number_format($nilaiAkhir, 2) }}
      </td>
      <td>{{ $predikat }}</td>
    </tr>
  </tbody>
</table>

<br>

<table style="width: 100%; border-collapse: collapse;" border="1">
  <tr>
    <td colspan="2"><strong>Predikat:</strong></td>
  </tr>
  <tr>
    <td style="padding: 6px;">A = 85 - 100</td>
    <td style="padding: 6px;">Sangat Baik</td>
  </tr>
  <tr>
    <td style="padding: 6px;">B = 75 - 84</td>
    <td style="padding: 6px;">Baik</td>
  </tr>
  <tr>
    <td style="padding: 6px;">C = 65 - 74</td>
    <td style="padding: 6px;">Cukup</td>
  </tr>
  <tr>
    <td style="padding: 6px;">D = 0 - 64</td>
    <td style="padding: 6px;">Kurang</td>
  </tr>
</table>

</body>
</html>
