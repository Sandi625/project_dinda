@extends('layouts.master') {{-- Pastikan base menggunakan SB Admin --}}

@section('content')
<div class="container-fluid px-4 mt-4">
    <h1 class="mt-4">Dashboard Kepala Sekolah</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Selamat datang, <strong>{{ Auth::user()->name }}</strong>! Anda login sebagai <strong>Kepala Sekolah</strong>.</li>
    </ol>

    {{-- Card Statistik --}}


    <div class="row justify-content-center">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-info text-white shadow h-100 py-2 text-center">
                <div class="card-body">
                    <div class="text-white text-uppercase mb-1 fw-bold">Total Feedback</div>
                    <div class="h2 mb-0">{{ $totalFeedback }}</div>
                </div>
            </div>
        </div>

       <div class="col-xl-3 col-md-6 mb-4">
    <div class="card bg-success text-white shadow h-100 py-2 text-center">
        <div class="card-body">
            <div class="text-white text-uppercase mb-1 fw-bold">Total User</div>
            <div class="h2 mb-0">{{ $totalUser }}</div>
        </div>
    </div>
</div>

    </div>
<div class="container-fluid px-4 mt-4">
    <div class="row">
        <!-- Grafik Bar (60%) -->
        <div class="col-lg-7 col-md-12 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Rata-Rata Penilaian per Kriteria per Guru
                    </h6>
                </div>
                <div class="card-body">
                    <div style="height: 350px;">
                        <canvas id="kriteriaPerGuruChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Line Chart (40%) -->
      <div class="col-lg-5 col-md-12 mb-4">
    <div class="card shadow h-100">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Grafik Garis - Rata-rata Nilai per Kriteria
            </h6>
        </div>
        <div class="card-body p-3">
            <div style="height: 100%; min-height: 300px;">
                <canvas id="lineChartKriteria" style="width: 100%; height: 100%;"></canvas>
            </div>
        </div>
    </div>
</div>


    <!-- Grafik Line per Guru per Periode -->
   <div class="card shadow mb-3">
    <div class="card-header bg-white py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            Grafik Nilai per Guru per Periode
        </h6>
    </div>
    <div class="card-body">
        <div style="height: 150px;">
            <canvas id="chartGuruPeriode"></canvas>
        </div>
    </div>
</div>


</div>




<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const rawPenilaianBar = @json($penilaian);

    const userListBar = [...new Set(rawPenilaianBar.map(p => p.user))];
    const kriteriaListBar = [...new Set(rawPenilaianBar.map(p => p.kriteria))];

    const warnaBar = [
        'rgba(75, 192, 192, 0.5)',
        'rgba(255, 99, 132, 0.5)',
        'rgba(255, 206, 86, 0.5)',
        'rgba(54, 162, 235, 0.5)',
        'rgba(153, 102, 255, 0.5)',
        'rgba(255, 159, 64, 0.5)',
    ];

    const datasetBar = kriteriaListBar.map((kriteria, idx) => ({
        label: kriteria,
        backgroundColor: warnaBar[idx % warnaBar.length],
        borderColor: warnaBar[idx % warnaBar.length].replace('0.5', '1'),
        borderWidth: 1,
        data: userListBar.map(user => {
            const found = rawPenilaianBar.find(p => p.user === user && p.kriteria === kriteria);
            return found ? found.rata_rata : 0;
        }),
    }));

    new Chart(document.getElementById("kriteriaPerGuruChart").getContext("2d"), {
        type: 'bar',
        data: {
            labels: userListBar,
            datasets: datasetBar
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: { display: true, text: 'Rata-Rata Nilai' }
                },
                x: {
                    title: { display: true, text: 'Nama User' } // ganti dari 'Nama Guru'
                }
            },
            plugins: {
                tooltip: { mode: 'index', intersect: false },
                title: { display: false }
            }
        }
    });
</script>



<script>
    const labelsLineKriteria = @json($penilaian->pluck('kriteria'));
    const dataLineKriteria = @json($penilaian->pluck('rata_rata'));

    new Chart(document.getElementById("lineChartKriteria").getContext("2d"), {
        type: 'line',
        data: {
            labels: labelsLineKriteria,
            datasets: [{
                label: 'Rata-rata Nilai',
                data: dataLineKriteria,
                borderColor: 'rgba(54, 162, 235, 1)',
                backgroundColor: 'rgba(54, 162, 235, 0.1)',
                pointBackgroundColor: 'rgba(54, 162, 235, 1)',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: 'rgba(54, 162, 235, 1)',
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: { display: true, text: 'Nilai' }
                },
                x: {
                    title: { display: true, text: 'Kriteria' }
                }
            },
            plugins: {
                legend: { display: false }
            }
        }
    });
</script>



<script>
    const rawLinePeriode = @json($penilaian);

    const userListLinePeriode = [...new Set(rawLinePeriode.map(d => d.user))];
    const periodeListLine = [...new Set(rawLinePeriode.map(d => d.periode))].sort();

    const warnaUserLine = [
        '#3b82f6', '#10b981', '#f59e0b', '#ef4444',
        '#8b5cf6', '#ec4899', '#14b8a6', '#eab308'
    ];

    const datasetLinePeriode = userListLinePeriode.map((user, i) => ({
        label: user,
        data: periodeListLine.map(periode => {
            const found = rawLinePeriode.find(d => d.user === user && d.periode === periode);
            return found ? found.rata_rata : null;
        }),
        borderColor: warnaUserLine[i % warnaUserLine.length],
        backgroundColor: warnaUserLine[i % warnaUserLine.length] + '33',
        fill: false,
        tension: 0.3
    }));

    new Chart(document.getElementById("chartGuruPeriode").getContext("2d"), {
        type: 'line',
        data: {
            labels: periodeListLine,
            datasets: datasetLinePeriode
        },
        options: {
            responsive: true,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: { position: 'top' },
                tooltip: { mode: 'nearest' }
            },
            scales: {
                x: { title: { display: true, text: 'Periode (Bulan)' }},
                y: { beginAtZero: true, title: { display: true, text: 'Rata-rata Nilai' }}
            }
        }
    });
</script>





@endsection

