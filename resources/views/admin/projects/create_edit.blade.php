@extends('layouts.app')
@section('title', $project->exists ? 'Edit Proyek' : 'Tambah Proyek')

@section('page_header')
<h1 class="h3 text-gray-800 mb-3">{{ $project->exists ? 'Edit Proyek' : 'Tambah Proyek' }}</h1>
@endsection

@section('content')
<div class="row">
  <div class="col-lg-9">
    <div class="card shadow mb-4">
      <div class="card-body">
        <form method="POST"
              action="{{ $project->exists ? route('admin.projects.update',$project) : route('admin.projects.store') }}"
              enctype="multipart/form-data">
          @csrf
          @if($project->exists) @method('PUT') @endif

          <div class="form-row">
            <div class="form-group col-md-8">
              <label>Nama Proyek <span class="text-danger">*</span></label>
              <input type="text" name="nama_proyek" class="form-control" value="{{ old('nama_proyek',$project->nama_proyek) }}" required>
              @error('nama_proyek')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
            <div class="form-group col-md-4">
              <label>Klien <span class="text-danger">*</span></label>
              <select name="client_id" class="form-control" required>
                <option value="">— Pilih —</option>
                @foreach($clients as $c)
                  <option value="{{ $c->id }}" {{ old('client_id',$project->client_id)==$c->id ? 'selected':'' }}>{{ $c->nama_klien }}</option>
                @endforeach
              </select>
              @error('client_id')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-4">
              <label>Kategori</label>
              <input type="text" name="kategori_proyek" class="form-control" value="{{ old('kategori_proyek',$project->kategori_proyek) }}" placeholder="Website / Mobile / IoT / ERP">
            </div>
            <div class="form-group col-md-4">
              <label>Status</label>
              @php $sts=['Draft','On Progress','Testing','Selesai','Maintenance']; @endphp
              <select name="status_proyek" class="form-control">
                @foreach($sts as $s)
                  <option value="{{ $s }}" {{ old('status_proyek',$project->status_proyek ?? 'Draft')==$s ? 'selected':'' }}>{{ $s }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group col-md-4">
              <label>Teknologi</label>
              <input type="text" name="teknologi_digunakan" class="form-control" value="{{ old('teknologi_digunakan',$project->teknologi_digunakan) }}" placeholder="Laravel, Flutter, Firebase">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label>Tanggal Mulai</label>
              <input type="date" name="tanggal_mulai" class="form-control" value="{{ old('tanggal_mulai',optional($project->tanggal_mulai)->format('Y-m-d')) }}">
            </div>
            <div class="form-group col-md-6">
              <label>Tanggal Selesai</label>
              <input type="date" name="tanggal_selesai" class="form-control" value="{{ old('tanggal_selesai',optional($project->tanggal_selesai)->format('Y-m-d')) }}">
            </div>
          </div>

          <div class="form-group">
            <label>Deskripsi Proyek</label>
            <textarea name="deskripsi_proyek" class="form-control" rows="3">{{ old('deskripsi_proyek',$project->deskripsi_proyek) }}</textarea>
          </div>

          <div class="form-group">
            <label>Fitur Utama</label>
            <textarea name="fitur_utama" class="form-control" rows="3" placeholder="Pisahkan dengan koma atau baris baru">{{ old('fitur_utama',$project->fitur_utama) }}</textarea>
          </div>

          <div class="form-row">
            <div class="form-group col-md-4">
              <label>Nilai Proyek (Rp)</label>
              <input type="number" step="0.01" name="nilai_proyek" class="form-control" value="{{ old('nilai_proyek',$project->nilai_proyek) }}">
            </div>
            <div class="form-group col-md-4">
              <label>URL Demo</label>
              <input type="url" name="url_demo" class="form-control" value="{{ old('url_demo',$project->url_demo) }}">
            </div>
            <div class="form-group col-md-4">
              <label>Repository URL</label>
              <input type="url" name="repo_url" class="form-control" value="{{ old('repo_url',$project->repo_url) }}">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-8">
              <label>Catatan Tambahan</label>
              <textarea name="catatan_tambahan" class="form-control" rows="2">{{ old('catatan_tambahan',$project->catatan_tambahan) }}</textarea>
            </div>
            <div class="form-group col-md-4">
              <label>Gambar Proyek</label>
              <input type="file" name="gambar_proyek" class="form-control-file">
              @if($project->gambar_url)
                <div class="mt-2"><img src="{{ $project->gambar_url }}" style="height:60px"></div>
              @endif
            </div>
          </div>

          <div class="d-flex justify-content-between">
            <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary">Kembali</a>
            <button class="btn btn-primary">{{ $project->exists ? 'Perbarui' : 'Simpan' }}</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
