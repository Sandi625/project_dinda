@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Dashboard Guru</h1>
    <p>Halo, {{ Auth::user()->name }}! Anda login sebagai <strong>Guru</strong>.</p>
</div>
@endsection
