@extends('layouts.app')

@section('title', 'Detail Klien')

@section('content')
<div class="container py-4">
    <a href="{{ route('admin.clients.index') }}" class="btn btn-sm btn-secondary mb-3">← Kembali</a>

    <div class="card">
        <div class="card-body">
            <h3>{{ $client->nama_klien }}</h3>
            <p><strong>Jenis:</strong> {{ $client->jenis_klien ?? '-' }}</p>
            <p><strong>Email:</strong> {{ $client->email ?? '-' }}</p>
            <p><strong>Telepon:</strong> {{ $client->telepon ?? '-' }}</p>
            <p><strong>Website:</strong>
                @if($client->website)
                    <a href="{{ $client->website }}" target="_blank">{{ $client->website }}</a>
                @else
                    -
                @endif
            </p>
            <p><strong>Alamat:</strong><br>{!! nl2br(e($client->alamat ?? '-')) !!}</p>

            @if($client->logo)
                <div class="mt-3">
                    <img src="{{ asset('storage/' . $client->logo) }}" alt="logo" style="height:80px;">
                </div>
            @endif

            <hr>
            <h5>Deskripsi</h5>
            <p>{!! nl2br(e($client->deskripsi_klien ?? '-')) !!}</p>

            <div class="mt-3">
                <a href="{{ route('admin.clients.edit', $client) }}" class="btn btn-primary">Edit</a>

                <form action="{{ route('admin.clients.destroy', $client) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Hapus klien ini?');">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
