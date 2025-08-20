@extends('admin.layouts.app')

@section('title', 'Detail Pendaftar - ' . $prodi->nama)

@section('page-title', 'Detail Pendaftar - ' . $prodi->nama)

@section('content')
    <!-- Header untuk Print -->
    <div id="print-header" class="text-center mb-4" style="display: none;">
        <h2>LAPORAN DETAIL PENDAFTAR</h2>
        <h3>UNIVERSITAS SELAMAT SRI</h3>
        <h4>SISTEM PENERIMAAN MAHASISWA BARU (SINEMANIS)</h4>
        <hr>
        <div class="row">
            <div class="col-6 text-start">
                <p><strong>Program Studi:</strong> {{ $prodi->nama }}</p>
                <p><strong>Jenjang:</strong> {{ $prodi->jenjang }}</p>
                <p><strong>Kuota:</strong> {{ $prodi->kuota }}</p>
            </div>
            <div class="col-6 text-end">
                <p><strong>Tanggal Cetak:</strong> {{ date('d M Y, H:i') }} WIB</p>
                @if(request('status'))
                    <p><strong>Status Filter:</strong> {{ ucfirst(request('status')) }}</p>
                @endif
                <p><strong>Total Data:</strong> {{ $pendaftars->count() }}</p>
            </div>
        </div>
    </div>

    <!-- Controls -->
    <div class="card mb-4" id="control-panel">
        <div class="card-body d-flex justify-content-between align-items-center">
            <a href="{{ route('admin.laporan.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
            <button type="button" onclick="window.print()" class="btn btn-success">
                <i class="fas fa-print me-1"></i> Cetak
            </button>
        </div>
    </div>

    <!-- Statistik Ringkasan -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Statistik {{ $prodi->nama }}</h5>
        </div>
        <div class="card-body">
            <div class="row text-center">
                <div class="col-md-2">
                    <div class="border rounded p-3">
                        <h4 class="text-primary mb-1">{{ $statistik['total'] }}</h4>
                        <small class="text-muted">Total</small>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="border rounded p-3">
                        <h4 class="text-warning mb-1">{{ $statistik['pending'] }}</h4>
                        <small class="text-muted">Menunggu</small>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="border rounded p-3">
                        <h4 class="text-info mb-1">{{ $statistik['verified'] }}</h4>
                        <small class="text-muted">Terverifikasi</small>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="border rounded p-3">
                        <h4 class="text-success mb-1">{{ $statistik['accepted'] }}</h4>
                        <small class="text-muted">Diterima</small>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="border rounded p-3">
                        <h4 class="text-danger mb-1">{{ $statistik['rejected'] }}</h4>
                        <small class="text-muted">Ditolak</small>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="border rounded p-3">
                        <h4 class="text-secondary mb-1">{{ $prodi->kuota }}</h4>
                        <small class="text-muted">Kuota</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Data Pendaftar -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Daftar Pendaftar</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th width="5%">No</th>
        <th width="8%">Foto</th>
                            <th width="20%">Nama Lengkap</th>
                            <th width="18%">Email</th>
                            <th width="12%">No. HP</th>
                            <th width="10%">Kelas</th>
                            <th width="12%">Tanggal Daftar</th>
                            <th width="10%">Status</th>
                            <th width="13%" class="no-print">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pendaftars as $index => $pendaftar)
                            <tr>
                                <td>{{ $index + 1 }}</td>
        <td>
            @php
                $foto = $pendaftar->foto_url
                    ?? $pendaftar->foto
                    ?? $pendaftar->photo
                    ?? $pendaftar->profile_photo_url
                    ?? null;
                if ($foto && !\Illuminate\Support\Str::startsWith($foto, ['http://','https://','data:'])) {
                    $foto = asset('storage/' . ltrim($foto, '/'));
                }
                $placeholder = asset('images/user-placeholder.png');
            @endphp
            <img src="{{ $foto ?: $placeholder }}" alt="Foto {{ $pendaftar->name }}" style="width:48px;height:48px;object-fit:cover;border-radius:6px;border:1px solid #ddd;">
        </td>

                                <td class="fw-bold">{{ $pendaftar->name }}</td>
                                <td>{{ $pendaftar->email }}</td>
                                <td>{{ $pendaftar->phone ?? 'N/A' }}</td>
                                <td>{{ $pendaftar->kelas ?? 'N/A' }}</td>
                                <td>{{ $pendaftar->created_at->format('d M Y') }}</td>
                                <td>
                                    @switch($pendaftar->status)
                                        @case('pending')
                                            <span class="badge bg-warning text-dark">Menunggu</span>
                                            @break
                                        @case('verified')
                                            <span class="badge bg-info">Terverifikasi</span>
                                            @break
                                        @case('accepted')
                                            <span class="badge bg-success">Diterima</span>
                                            @break
                                        @case('rejected')
                                            <span class="badge bg-danger">Ditolak</span>
                                            @break
                                    @endswitch
                                </td>
                                <td class="no-print">
                                    <a href="{{ route('admin.pendaftar.show', $pendaftar->id) }}" 
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                    Tidak ada data pendaftar
                                    @if(request('status'))
                                        dengan status {{ request('status') }}
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Footer Print -->
    <div id="print-footer" class="mt-4 text-center" style="display: none;">
        <hr>
        <p><small>Laporan ini digenerate secara otomatis oleh Sistem SINEMANIS - Universitas Selamat Sri</small></p>
        <p><small>Dicetak pada: {{ date('d M Y, H:i') }} WIB</small></p>
    </div>
@endsection

@push('styles')
<style>
    @media print {
        /* Hide elements that shouldn't appear in print */
        #control-panel,
        .no-print,
        .btn,
        .sidebar,
        .topbar,
        .navbar {
            display: none !important;
        }
        
        /* Show print-only elements */
        #print-header,
        #print-footer {
            display: block !important;
        }
        
        /* Adjust layout for print */
        .content-wrapper {
            margin-left: 0 !important;
        }
        
        .card {
            border: none !important;
            box-shadow: none !important;
            page-break-inside: avoid;
        }
        
        .card-header {
            background-color: #f8f9fa !important;
            border-bottom: 2px solid #333 !important;
            -webkit-print-color-adjust: exact;
        }
        
        /* Table styling for print */
        .table {
            font-size: 10px !important;
        }
        
        .table thead th {
            background-color: #343a40 !important;
            color: white !important;
            -webkit-print-color-adjust: exact;
        }
        
        /* Ensure badge colors are visible in print */
        .badge {
            -webkit-print-color-adjust: exact;
            border: 1px solid #000;
        }
        
        .bg-warning { background-color: #ffc107 !important; }
        .bg-info { background-color: #0dcaf0 !important; }
        .bg-success { background-color: #198754 !important; }
        .bg-danger { background-color: #dc3545 !important; }
        
        /* Print page settings */
        @page {
            margin: 1cm;
            size: A4 landscape; /* Landscape untuk tabel yang lebar */
        }
        
        body {
            -webkit-print-color-adjust: exact;
        }
    }
    
    /* Screen styling */
    @media screen {
        .table-striped > tbody > tr:nth-of-type(odd) > td {
            background-color: rgba(0,0,0,.02);
        }
    }
</style>
@endpush