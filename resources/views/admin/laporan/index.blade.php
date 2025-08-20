@extends('admin.layouts.app')

@section('title', 'Laporan Data Pendaftar')

@section('page-title', 'Laporan Data Pendaftar')

@section('content')
    <!-- Print Control -->
    <div class="card mb-4" id="control-panel">
        <div class="card-body text-end">
            <button type="button" onclick="window.print()" class="btn btn-success">
                <i class="fas fa-print me-1"></i> Cetak
            </button>
        </div>
    </div>

    <!-- Header Laporan untuk Print -->
    <div id="print-header" class="text-center mb-4" style="display: none;">
        <h2>LAPORAN DATA PENDAFTAR</h2>
        <h3>UNIVERSITAS SELAMAT SRI</h3>
        <h4>SISTEM PENERIMAAN MAHASISWA BARU (SINEMANIS)</h4>
        <hr>
        <p><strong>Tanggal Cetak:</strong> {{ date('d M Y, H:i') }} WIB</p>
    </div>

    <!-- Ringkasan Statistik -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Ringkasan Statistik</h5>
        </div>
        <div class="card-body">
            <div class="row text-center">
                <div class="col-md-3">
                    <div class="border rounded p-3">
                        <h4 class="text-primary mb-1">{{ $statistik['total'] }}</h4>
                        <small class="text-muted">Total Pendaftar</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="border rounded p-3">
                        <h4 class="text-warning mb-1">{{ $statistik['pending'] }}</h4>
                        <small class="text-muted">Menunggu</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="border rounded p-3">
                        <h4 class="text-info mb-1">{{ $statistik['verified'] }}</h4>
                        <small class="text-muted">Terverifikasi</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="border rounded p-3">
                        <h4 class="text-success mb-1">{{ $statistik['accepted'] }}</h4>
                        <small class="text-muted">Diterima</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Per Program Studi -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Statistik Per Program Studi</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th width="5%">No</th>
                            <th width="25%">Program Studi</th>
                            <th width="10%">Jenjang</th>
                            <th width="10%">Kuota</th>
                            <th width="10%">Total</th>
                            <th width="10%">Menunggu</th>
                            <th width="10%">Terverifikasi</th>
                            <th width="10%">Diterima</th>
                            <th width="10%" class="no-print">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($prodiStats as $index => $prodi)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td class="fw-bold">{{ $prodi->nama }}</td>
                                <td>{{ $prodi->jenjang }}</td>
                                <td>{{ $prodi->kuota }}</td>
                                <td class="fw-bold text-primary">{{ $prodi->total_pendaftar }}</td>
                                <td class="text-warning">{{ $prodi->pending_count }}</td>
                                <td class="text-info">{{ $prodi->verified_count }}</td>
                                <td class="text-success">{{ $prodi->accepted_count }}</td>
                                <td class="no-print">
                                    <a href="{{ route('admin.laporan.detail-prodi', $prodi->id) }}" 
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye me-1"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light">
                        <tr class="fw-bold">
                            <td colspan="4">TOTAL KESELURUHAN</td>
                            <td class="text-primary">{{ $prodiStats->sum('total_pendaftar') }}</td>
                            <td class="text-warning">{{ $prodiStats->sum('pending_count') }}</td>
                            <td class="text-info">{{ $prodiStats->sum('verified_count') }}</td>
                            <td class="text-success">{{ $prodiStats->sum('accepted_count') }}</td>
                            <td class="no-print"></td>
                        </tr>
                    </tfoot>
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
        .topbar {
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
            font-size: 11px !important;
        }
        
        .table thead th {
            background-color: #343a40 !important;
            color: white !important;
            -webkit-print-color-adjust: exact;
        }
        
        /* Ensure text colors are visible in print */
        .text-primary { color: #0d6efd !important; }
        .text-warning { color: #fd7e14 !important; }
        .text-info { color: #0dcaf0 !important; }
        .text-success { color: #198754 !important; }
        .text-danger { color: #dc3545 !important; }
        
        /* Print-specific styling */
        body {
            -webkit-print-color-adjust: exact;
        }
    }
    
    /* Screen-only styling */
    @media screen {
        .table-striped > tbody > tr:nth-of-type(odd) > td {
            background-color: rgba(0,0,0,.02);
        }
    }
</style>
@endpush

{{-- Scripts section tidak diperlukan lagi karena tidak menggunakan AJAX --}}