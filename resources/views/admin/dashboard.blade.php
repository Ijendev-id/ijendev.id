@extends('layouts.app')

@section('title', 'Admin Dashboard')

@php
    // ===== Fallback kalau controller belum mengirim data =====
    use App\Models\Client;
    use App\Models\Project;

    $totalClients      = $totalClients      ?? (class_exists(Client::class)  ? Client::count() : 0);
    $totalProjects     = $totalProjects     ?? (class_exists(Project::class) ? Project::count() : 0);
    $activeProjects    = $activeProjects    ?? (class_exists(Project::class) ? Project::where('status_proyek','On Progress')->count() : 0);
    $completedProjects = $completedProjects ?? (class_exists(Project::class) ? Project::where('status_proyek','Selesai')->count() : 0);

    // Ambil 5 terbaru
    $latestProjects = $latestProjects ?? (class_exists(Project::class)
        ? Project::with('client')->latest()->take(5)->get()
        : collect());

    $latestClients = $latestClients ?? (class_exists(Client::class)
        ? Client::latest()->take(5)->get()
        : collect());

    // Breakdown status untuk chart
    $statuses = ['Draft','On Progress','Testing','Selesai','Maintenance'];
    $statusBreakdown = $statusBreakdown ?? (class_exists(Project::class)
        ? collect($statuses)->mapWithKeys(fn($s) => [$s => Project::where('status_proyek',$s)->count()])->toArray()
        : array_fill_keys($statuses, 0));
@endphp

{{-- Header --}}
@section('page_header')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800">Admin Dashboard</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent p-0 mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
        </nav>
    </div>
    <div class="btn-group">
        <a href="{{ route('admin.projects.create') }}" class="btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Proyek Baru
        </a>
        <a href="{{ route('admin.clients.create') }}" class="btn btn-sm btn-outline-primary shadow-sm">
            <i class="fas fa-user-plus fa-sm"></i> Klien Baru
        </a>
    </div>
</div>
@endsection

@section('content')
{{-- KPI Row --}}
<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body d-flex align-items-center">
                <div class="mr-auto">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Klien</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalClients }}</div>
                </div>
                <i class="fas fa-user-tie fa-2x text-gray-300"></i>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body d-flex align-items-center">
                <div class="mr-auto">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Proyek</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalProjects }}</div>
                </div>
                <i class="fas fa-briefcase fa-2x text-gray-300"></i>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body d-flex align-items-center">
                <div class="mr-auto">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Proyek Aktif</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $activeProjects }}</div>
                </div>
                <i class="fas fa-play-circle fa-2x text-gray-300"></i>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body d-flex align-items-center">
                <div class="mr-auto">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Proyek Selesai</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $completedProjects }}</div>
                </div>
                <i class="fas fa-check-circle fa-2x text-gray-300"></i>
            </div>
        </div>
    </div>
</div>

{{-- Chart + Quick Stats --}}
<div class="row">
    {{-- Donut Status Proyek --}}
    <div class="col-xl-5 col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Status Proyek</h6>
                <a href="{{ route('admin.projects.index') }}" class="small">Lihat semua</a>
            </div>
            <div class="card-body">
                <div class="chart-pie pt-3 pb-2">
                    <canvas id="chartProjectStatus"></canvas>
                </div>
                <div class="mt-4 text-center small">
                    @foreach($statuses as $s)
                        <span class="mr-3"><i class="fas fa-circle"></i> {{ $s }} ({{ $statusBreakdown[$s] ?? 0 }})</span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Ringkasan Cepat --}}
    <div class="col-xl-7 col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Ringkasan</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    {{-- Progress Bar Komposisi --}}
                    @php
                        $totalForBar = array_sum($statusBreakdown) ?: 1;
                    @endphp
                    <div class="col-12 mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="small text-muted">Komposisi Status</span>
                            <span class="small text-muted">{{ $totalProjects }} proyek</span>
                        </div>
                        <div class="progress" style="height: 10px;">
                            @foreach($statuses as $s)
                                @php
                                    $pct = round(100 * ($statusBreakdown[$s] ?? 0) / $totalForBar, 2);
                                    $cls = match($s){
                                        'Draft' => 'bg-secondary',
                                        'On Progress' => 'bg-info',
                                        'Testing' => 'bg-warning',
                                        'Selesai' => 'bg-success',
                                        'Maintenance' => 'bg-primary',
                                        default => 'bg-light'
                                    };
                                @endphp
                                @if($pct > 0)
                                    <div class="progress-bar {{ $cls }}" role="progressbar" style="width: {{ $pct }}%" title="{{ $s }} {{ $pct }}%"></div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="border-left-primary pl-3 mb-3">
                            <div class="small text-muted">Klien Baru (5 terakhir)</div>
                            <div class="font-weight-bold">{{ $latestClients->count() }}</div>
                            <div class="mt-2">
                                @forelse($latestClients as $c)
                                    <div class="small text-truncate mb-1">
                                        <i class="fas fa-user mr-1 text-muted"></i>{{ $c->nama_klien }}
                                    </div>
                                @empty
                                    <div class="small text-muted">Belum ada.</div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="border-left-success pl-3 mb-3">
                            <div class="small text-muted">Proyek Baru (5 terakhir)</div>
                            <div class="font-weight-bold">{{ $latestProjects->count() }}</div>
                            <div class="mt-2">
                                @forelse($latestProjects as $p)
                                    <div class="small text-truncate mb-1">
                                        <i class="fas fa-briefcase mr-1 text-muted"></i>{{ $p->nama_proyek }}
                                        <span class="text-muted">·</span>
                                        <span class="text-muted">{{ $p->status_proyek }}</span>
                                    </div>
                                @empty
                                    <div class="small text-muted">Belum ada.</div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mt-2">
                        <a href="{{ route('admin.clients.create') }}" class="btn btn-sm btn-outline-primary mr-2">
                            <i class="fas fa-user-plus mr-1"></i> Tambah Klien
                        </a>
                        <a href="{{ route('admin.projects.create') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus mr-1"></i> Tambah Proyek
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Tabel ringkas --}}
<div class="row">
    <div class="col-lg-7 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Proyek Terbaru</h6>
                <a href="{{ route('admin.projects.index') }}" class="small">Semua proyek</a>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-sm table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Proyek</th>
                            <th>Klien</th>
                            <th>Status</th>
                            <th>Tgl Mulai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($latestProjects as $p)
                            <tr>
                                <td class="text-truncate">{{ $p->nama_proyek }}</td>
                                <td class="text-truncate">{{ $p->client->nama_klien ?? '-' }}</td>
                                <td><span class="badge badge-pill
                                    {{ $p->status_proyek === 'Selesai' ? 'badge-success' :
                                       ($p->status_proyek === 'On Progress' ? 'badge-info' :
                                       ($p->status_proyek === 'Testing' ? 'badge-warning' :
                                       ($p->status_proyek === 'Maintenance' ? 'badge-primary' : 'badge-secondary'))) }}">
                                    {{ $p->status_proyek ?? '-' }}
                                </span></td>
                                <td>{{ optional($p->tanggal_mulai)->format('Y-m-d') ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-muted">Belum ada data.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-5 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Klien Terbaru</h6>
                <a href="{{ route('admin.clients.index') }}" class="small">Semua klien</a>
            </div>
            <div class="card-body">
                @forelse($latestClients as $c)
                    <div class="d-flex align-items-center mb-3">
                        <div class="mr-3" style="width:40px;height:40px;">
                            @if(method_exists($c, 'getLogoUrlAttribute') && $c->logo_url)
                                <img src="{{ $c->logo_url }}" alt="logo" class="rounded" style="width:40px;height:40px;object-fit:cover;">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width:40px;height:40px;">
                                    <i class="fas fa-user text-muted"></i>
                                </div>
                            @endif
                        </div>
                        <div class="flex-grow-1">
                            <div class="font-weight-bold text-truncate">{{ $c->nama_klien }}</div>
                            <div class="small text-muted text-truncate">{{ $c->jenis_klien ?? '—' }}</div>
                        </div>
                        <a href="{{ route('admin.clients.edit', $c) }}" class="btn btn-sm btn-outline-secondary">Kelola</a>
                    </div>
                @empty
                    <div class="text-muted small">Belum ada data.</div>
                @endforelse
                <div class="mt-3">
                    <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.clients.create') }}">
                        <i class="fas fa-user-plus mr-1"></i> Tambah Klien
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- Chart.js --}}
@push('vendor_js')
<script src="{{ asset('assets_dashboard/vendor/chart.js/Chart.min.js') }}"></script>
@endpush

@push('extra_js')
<script>
    (function(){
        var ctx = document.getElementById('chartProjectStatus');
        if(!ctx || typeof Chart === 'undefined') return;

        // Data dari PHP
        var labels = @json(array_keys($statusBreakdown));
        var values = @json(array_values($statusBreakdown));

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{ data: values }]
            },
            options: {
                maintainAspectRatio: false,
                legend: { position: 'bottom' },
                cutoutPercentage: 60,
                tooltips: { enabled: true }
            }
        });
    })();
</script>
@endpush
