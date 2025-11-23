@extends('layout.app')

@section('content')
<div class="container mt-4">
    <h1>Dashboard Payment</h1>

    <p class="mt-3">
        Selamat datang, <strong>{{ session('user')->nama }}</strong>!
    </p>
</div>
@endsection
