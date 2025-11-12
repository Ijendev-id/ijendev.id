{{-- resources/views/user/dashboard.blade.php --}}
@extends('user.layouts.app')

@section('title', 'Dashboard User')

@section('content')
<div class="container">
    <h1>Selamat datang, {{ auth()->user()->name }}!</h1>
    <p>Ini adalah dashboard untuk user biasa.</p>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <p>Email: {{ auth()->user()->email }}</p>
            <p>Role: {{ auth()->user()->role }}</p>
        </div>
    </div>
</div>
@endsection
