@extends('layouts.master')

@section('content')
<div class="container">
    <h1>Dashboard Kepala Sekolah</h1>
    <p>Halo, {{ Auth::user()->name }}! Anda login sebagai <strong>Kepala Sekolah</strong>.</p>
</div>
@endsection
