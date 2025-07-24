@extends('layouts.master')

@section('content')
<div class="container">
    <h4>Daftar Feedback</h4>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Tanggal</th>
                <th>Guru</th>
                <th>Kelas</th>
                <th>Mapel</th>
                <th>Isi Feedback</th>
            </tr>
        </thead>
        <tbody>
            @foreach($feedbacks as $feedback)
                <tr>
                    <td>{{ $feedback->tanggal }}</td>
                    <td>{{ $feedback->penilaian->guru->nama ?? '-' }}</td>
                    <td>{{ $feedback->penilaian->kelas->nama_kelas ?? '-' }}</td>
                    <td>{{ $feedback->penilaian->mapel->nama_mapel ?? '-' }}</td>
                    <td>{{ $feedback->isi }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
