@extends('user.layouts.app')

@section('title', 'Proyek Saya')

@section('content')
<div class="container">
    <h1>Proyek Saya</h1>

    @if($projects->isEmpty())
        <div class="alert alert-info">Belum ada proyek yang terdaftar untuk email Anda.</div>
    @else
        <div class="row">
            @foreach($projects as $project)
                <div class="col-md-6 mb-3">
                    <div class="card h-100">
                        @if($project->gambar_proyek)
                            <img src="{{ asset('storage/' . $project->gambar_proyek) }}" class="card-img-top" alt="{{ $project->nama_proyek }}">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $project->nama_proyek }}</h5>
                            <p class="card-text">{{ \Illuminate\Support\Str::limit($project->deskripsi_proyek, 150) }}</p>
                            <p class="mb-1"><small>Client: {{ $project->client?->nama_klien ?? '-' }}</small></p>
                            <p class="mb-1"><small>Status: {{ $project->status_proyek }}</small></p>
                            <a href="{{ route('user.projects.show', $project) }}" class="btn btn-primary btn-sm">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
