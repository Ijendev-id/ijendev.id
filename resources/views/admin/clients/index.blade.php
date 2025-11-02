@extends('layouts.app')
@section('title','Data Klien')

@section('page_header')
<div class="d-sm-flex align-items-center justify-content-between mb-3">
  <h1 class="h3 text-gray-800 mb-0">Data Klien</h1>
  <a href="{{ route('admin.clients.create') }}" class="btn btn-primary btn-sm">
    <i class="fas fa-plus mr-1"></i> Tambah Klien
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
          <th>Logo</th>
          <th>Nama Klien</th>
          <th>Jenis</th>
          <th>Email</th>
          <th>Telepon</th>
          <th class="text-right">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($clients as $i => $c)
        <tr>
          <td>{{ $clients->firstItem() + $i }}</td>
          <td>
            @if($c->logo_url)
              <img src="{{ $c->logo_url }}" alt="logo" style="height:32px">
            @else
              <span class="text-muted">—</span>
            @endif
          </td>
          <td>{{ $c->nama_klien }}</td>
          <td>{{ $c->jenis_klien ?? '-' }}</td>
          <td>{{ $c->email ?? '-' }}</td>
          <td>{{ $c->telepon ?? '-' }}</td>
          <td class="text-right">
            <a href="{{ route('admin.clients.edit',$c) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
            <form action="{{ route('admin.clients.destroy',$c) }}" method="POST" class="d-inline"
                  onsubmit="return confirm('Hapus klien ini?')">
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
    <div class="mt-3">{{ $clients->links() }}</div>
  </div>
</div>
@endsection
