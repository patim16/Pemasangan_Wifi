@extends('layout.app')

@section('content')
<div class="container mt-4">
    <h1>Dashboard Customer!</h1>
    <p>Selamat datang, <strong>{{ session('user')->nama }}</strong>!</p>
    <p></p>
</div>
@endsection


