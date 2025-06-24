<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Data Penilaian</title>
    <style>
       @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

body {
    font-family: 'Poppins', sans-serif;
    font-size: 13px;
    color: #333;
    margin: 0;
    padding: 30px;
    background: #fefefe;
}

.header {
    display: flex;
    flex-direction: column;
    align-items: center;
    background-color: #004d99;
    color: white;
    padding: 15px 20px;
    border-radius: 6px;
    text-align: center;
    margin-bottom: 20px;
}

.header img {
    height: 60px;
    width: auto;
    margin-bottom: 10px;
}

.header .title {
    font-size: 16px;
    font-weight: 600;
    letter-spacing: 1px;
    text-transform: uppercase;
}


h2 {
    text-align: center;
    color: #004d99;
    margin: 25px 0 15px;
    font-weight: 600;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
    background: #fff;
    border: 1px solid #ccc;
}

th, td {
    padding: 10px 12px;
    text-align: left;
    border: 1px solid #ccc;
    vertical-align: top;
}

th {
    background-color: #004d99;
    color: white;
    text-transform: uppercase;
    font-size: 12px;
}

tr:nth-child(even) {
    background-color: #f2f7fd;
}

ul {
    padding-left: 16px;
    margin: 0;
}

.footer {
    margin-top: 30px;
    text-align: center;
    font-size: 11px;
    color: #555;
}

    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('images/logo.png') }}" alt="Logo Sekolah">
        <div class="title">SISTEM INFORMASI PENILAIAN GURU</div>
    </div>

    <h2>DAFTAR PENILAIAN GURU</h2>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Guru</th>
                <th>Periode</th>
                <th>Tanggal</th>
                <th>Kriteria & Nilai</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($penilaian as $p)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $p->guru->nama ?? '-' }}</td>
                <td>{{ $p->periode }}</td>
                <td>{{ \Carbon\Carbon::parse($p->tanggal)->format('d-m-Y') }}</td>
               <td>
    @php
        $totalNilai = $p->detailPenilaian->sum('nilai');
        $jumlahKriteria = $p->detailPenilaian->count();
        $maksNilai = $jumlahKriteria * 100;
        $nilaiAkhir = $jumlahKriteria ? ($totalNilai / $maksNilai) * 100 : 0;

        if ($nilaiAkhir >= 90) {
            $predikat = 'A (Sangat Baik)';
        } elseif ($nilaiAkhir >= 80) {
            $predikat = 'B (Baik)';
        } elseif ($nilaiAkhir >= 70) {
            $predikat = 'C (Cukup)';
        } elseif ($nilaiAkhir >= 60) {
            $predikat = 'D (Kurang)';
        } else {
            $predikat = 'E (Sangat Kurang)';
        }
    @endphp

    <ul>
        @foreach ($p->detailPenilaian as $detail)
            <li>
                <strong>{{ $detail->kriteria->nama }}</strong>:
                {{ number_format($detail->nilai, 2) }}
            </li>
        @endforeach
    </ul>

    <div style="margin-top: 8px;">
        <strong>Nilai Akhir:</strong> {{ number_format($nilaiAkhir, 2) }}<br>
        <strong>Predikat:</strong> {{ $predikat }}
    </div>
</td>

            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- <div class="footer">
        Laporan ini dicetak otomatis oleh sistem pada {{ \Carbon\Carbon::now()->format('d-m-Y H:i') }}
    </div> --}}
</body>

</html>
