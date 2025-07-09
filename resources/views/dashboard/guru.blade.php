@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Dashboard Guru</h1>
    <p>Halo, {{ Auth::user()->name }}! Anda login sebagai <strong>Guru</strong>.</p>

    {{-- Ringkasan --}}
    <div class="row my-4">
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-left-primary">
                <div class="card-body">
                    <h5 class="card-title">Total Penilaian</h5>
                    <p class="card-text display-6">{{ $totalPenilaian }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-left-success">
                <div class="card-body">
                    <h5 class="card-title">Rata-rata Nilai</h5>
                    <p class="card-text display-6">{{ number_format($rataNilai, 2) }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-left-warning">
                <div class="card-body">
                    <h5 class="card-title">Peringkat Anda</h5>
                    <p class="card-text display-6">#{{ $peringkat }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Grafik --}}
    <div class="card mt-4 shadow-sm">
        <div class="card-body">
            <h5 class="card-title mb-3">Perkembangan Nilai Per Bulan</h5>

            @if ($nilaiPerBulan->isEmpty())
                <p class="text-muted">Belum ada data penilaian untuk ditampilkan.</p>
            @else
                <canvas id="nilaiChart" height="100"></canvas>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

@if (!$nilaiPerBulan->isEmpty())
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('nilaiChart').getContext('2d');

    const labels = @json($nilaiPerBulan->pluck('bulan')->values());
    const data = @json($nilaiPerBulan->pluck('rata')->map(fn($v) => (float) $v)->values());

    new Chart(ctx, {
        type: 'bar', // ✅ Ganti dari 'line' ke 'bar'
        data: {
            labels: labels,
            datasets: [{
                label: 'Nilai Bulanan',
                data: data,
                backgroundColor: 'rgba(54, 162, 235, 0.6)', // Warna batang
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                datalabels: {
                    anchor: 'end',
                    align: 'top',
                    color: '#000',
                    font: {
                        weight: 'bold'
                    },
                    formatter: function(value) {
                        return value;
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Nilai'
                    },
                    suggestedMax: 100
                },
                x: {
                    title: {
                        display: true,
                        text: 'Bulan'
                    }
                }
            }
        },
        plugins: [ChartDataLabels]
    });
});
</script>
@endif
@endsection



