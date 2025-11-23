@extends('layout.app')

@section('content')
<div class="container mt-4">
    <h1>Dashboard Teknisi</h1>
    <p>Selamat datang, {{ session('user')->nama }}!</p>
    <p>Role: Teknisi</p>
</div>
@endsection
