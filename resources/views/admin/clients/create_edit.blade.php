@extends('layouts.app')
@section('title', $client->exists ? 'Edit Klien' : 'Tambah Klien')

@section('page_header')
<h1 class="h3 text-gray-800 mb-3">{{ $client->exists ? 'Edit Klien' : 'Tambah Klien' }}</h1>
@endsection

@section('content')
<div class="row">
  <div class="col-lg-8">
    <div class="card shadow mb-4">
      <div class="card-body">
        <form method="POST" action="{{ $client->exists ? route('admin.clients.update', $client) : route('admin.clients.store') }}">

          @csrf
          @if($client->exists) @method('PUT') @endif

          <div class="form-group">
            <label>Nama Klien <span class="text-danger">*</span></label>
            <input type="text" name="nama_klien" class="form-control" value="{{ old('nama_klien',$client->nama_klien) }}" required>
            @error('nama_klien')<small class="text-danger">{{ $message }}</small>@enderror
          </div>

          <div class="form-row">
            <div class="form-group col-md-4">
              <label>Jenis Klien</label>
              <select name="jenis_klien" class="form-control">
                @php $ops=['Perusahaan','Instansi','UMKM','Personal']; @endphp
                <option value="">— Pilih —</option>
                @foreach($ops as $op)
                <option value="{{ $op }}" {{ old('jenis_klien',$client->jenis_klien)===$op ? 'selected':'' }}>{{ $op }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group col-md-4">
              <label>Email</label>
              <input type="email" name="email" class="form-control" value="{{ old('email',$client->email) }}">
            </div>
            <div class="form-group col-md-4">
              <label>Telepon</label>
              <input type="text" name="telepon" class="form-control" value="{{ old('telepon',$client->telepon) }}">
            </div>
          </div>

          <div class="form-group">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control" rows="3">{{ old('alamat',$client->alamat) }}</textarea>
          </div>

          <div class="form-row">
            <div class="form-group col-md-8">
              <label>Website</label>
              <input type="url" name="website" class="form-control" value="{{ old('website',$client->website) }}">
            </div>
            <div class="form-group col-md-4">
              <label>Logo</label>
              <input type="file" name="logo" class="form-control-file">
              @if($client->logo_url)
                <div class="mt-2"><img src="{{ $client->logo_url }}" style="height:40px"></div>
              @endif
            </div>
          </div>

          <div class="form-group">
            <label>Deskripsi Klien</label>
            <textarea name="deskripsi_klien" class="form-control" rows="3">{{ old('deskripsi_klien',$client->deskripsi_klien) }}</textarea>
          </div>

          <div class="d-flex justify-content-between">
            <a href="{{ route('admin.clients.index') }}" class="btn btn-secondary">Kembali</a>
            <button class="btn btn-primary">{{ $client->exists ? 'Perbarui' : 'Simpan' }}</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
