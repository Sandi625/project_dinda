@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Jadwal Mengajar</h4>

    @if ($jadwal->isEmpty())
        <p>Tidak ada jadwal.</p>
    @else
        <p><strong>Nama Guru:</strong> {{ $jadwal->first()->guru->nama ?? '-' }}</p>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Hari</th>
                    <th>Jam Ke</th>
                    <th>Mata Pelajaran</th>
                    <th>Kelas</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jadwal as $item)
                    <tr>
                        <td>{{ $item->hari }}</td>
                        <td>
                            {{ 'Jam ke-' . $item->jam_ke }}
                            @php
                                $jamMap = [
                                    1 => '07:00 - 07:45',
                                    2 => '07:45 - 08:30',
                                    3 => '08:30 - 09:15',
                                    4 => '09:15 - 10:00',
                                    5 => '10:15 - 11:00',
                                    6 => '11:00 - 11:45',
                                    7 => '12:45 - 13:30',
                                    8 => '13:30 - 14:15',
                                    9 => '14:15 - 15:00',
                                    10 => '15:00 - 15:45',
                                ];
                            @endphp
                            <br><small class="text-muted">{{ $jamMap[$item->jam_ke] ?? '-' }}</small>
                        </td>
                        <td>{{ $item->mapel->nama_mapel ?? '-' }}</td>
                        <td>{{ $item->kelas->nama_kelas ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
