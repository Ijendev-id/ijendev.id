@extends('user.layouts.app')

@section('title', $project->nama_proyek)

@section('content')
<div class="container">
    <a href="{{ route('user.projects.index') }}" class="btn btn-link">&laquo; Kembali ke Proyek Saya</a>

    <div class="card mb-3">
        @if($project->gambar_proyek)
            <img src="{{ asset('storage/' . $project->gambar_proyek) }}" class="card-img-top" alt="{{ $project->nama_proyek }}">
        @endif
        <div class="card-body">
            <h3 class="card-title">{{ $project->nama_proyek }}</h3>
            <p><strong>Client:</strong> {{ $project->client?->nama_klien ?? '-' }} ({{ $project->client?->email ?? '-' }})</p>
            <p><strong>Kategori:</strong> {{ $project->kategori_proyek ?? '-' }}</p>
            <p><strong>Status:</strong> {{ $project->status_proyek ?? '-' }}</p>
            <p><strong>Tanggal Mulai:</strong> {{ $project->tanggal_mulai ?? '-' }}</p>
            <p><strong>Tanggal Selesai:</strong> {{ $project->tanggal_selesai ?? '-' }}</p>
            <p><strong>Nilai Proyek:</strong> {{ $project->nilai_proyek ? 'Rp ' . number_format($project->nilai_proyek, 0, ',', '.') : '-' }}</p>
            <hr>
            <h5>Deskripsi</h5>
            <p>{!! nl2br(e($project->deskripsi_proyek)) !!}</p>

            @if($project->fitur_utama)
                <h5>Fitur Utama</h5>
                <p>{!! nl2br(e($project->fitur_utama)) !!}</p>
            @endif

            @if($project->teknologi_digunakan)
                <h5>Teknologi</h5>
                <p>{{ $project->teknologi_digunakan }}</p>
            @endif

            @if($project->url_demo)
                <a href="{{ $project->url_demo }}" target="_blank" class="btn btn-outline-primary btn-sm">Demo</a>
            @endif
            @if($project->repo_url)
                <a href="{{ $project->repo_url }}" target="_blank" class="btn btn-outline-secondary btn-sm">Repo</a>
            @endif
        </div>
    </div>
</div>
@endsection
