@extends('layouts.app')
@section('title','Data Proyek')

@section('page_header')
<div class="d-sm-flex align-items-center justify-content-between mb-3">
  <h1 class="h3 text-gray-800 mb-0">Data Proyek</h1>
  <a href="{{ route('admin.projects.create') }}" class="btn btn-primary btn-sm">
    <i class="fas fa-plus mr-1"></i> Tambah Proyek
  </a>
</div>
@endsection

@section('content')
@if(session('status'))
  <div class="alert alert-success">{{ session('status') }}</div>
@endif

<div class="card shadow">
  <div class="card-body table-responsive">
    <table class="table table-striped align-middle">
      <thead>
        <tr>
          <th>#</th>
          <th>Proyek</th>
          <th>Klien</th>
          <th>Kategori</th>
          <th>Status</th>
          <th>Tgl Mulai</th>
          <th class="text-right">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($projects as $i => $p)
        <tr>
          <td>{{ $projects->firstItem() + $i }}</td>
          <td>{{ $p->nama_proyek }}</td>
          <td>{{ $p->client->nama_klien ?? '-' }}</td>
          <td>{{ $p->kategori_proyek ?? '-' }}</td>
          <td><span class="badge badge-info">{{ $p->status_proyek }}</span></td>
          <td>{{ optional($p->tanggal_mulai)->format('Y-m-d') ?? '-' }}</td>
          <td class="text-right">
            <a href="{{ route('admin.projects.edit',$p) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
            <form action="{{ route('admin.projects.destroy',$p) }}" method="POST" class="d-inline"
                  onsubmit="return confirm('Hapus proyek ini?')">
              @csrf @method('DELETE')
              <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="7" class="text-center text-muted">Belum ada data.</td></tr>
        @endforelse
      </tbody>
    </table>
    <div class="mt-3">{{ $projects->links() }}</div>
  </div>
</div>
@endsection
