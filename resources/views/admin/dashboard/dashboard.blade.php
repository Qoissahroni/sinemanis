@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('content')
    <!-- Statistik Pendaftar -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stats-card" style="background: linear-gradient(135deg, #2E3192, #1BAEEC);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stats-title">Total Pendaftar</div>
                        <div class="stats-number">{{ $totalPendaftar }}</div>
                    </div>
                    <div class="stats-icon">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stats-card" style="background: linear-gradient(135deg, #F58220, #F7941D);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stats-title">Pendaftar Terverifikasi</div>
                        <div class="stats-number">{{ $pendaftarTerverifikasi }}</div>
                    </div>
                    <div class="stats-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stats-card" style="background: linear-gradient(135deg, #28A745, #20C997);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stats-title">Pendaftar Diterima</div>
                        <div class="stats-number">{{ $pendaftarDiterima }}</div>
                    </div>
                    <div class="stats-icon">
                        <i class="fas fa-user-check"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stats-card" style="background: linear-gradient(135deg, #DC3545, #E74C3C);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stats-title">Menunggu Verifikasi</div>
                        <div class="stats-number">{{ $pendaftarMenunggu }}</div>
                    </div>
                    <div class="stats-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <!-- Pendaftar Terbaru -->
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Pendaftar Terbaru</span>
                    <a href="{{ route('admin.pendaftar.index') }}" class="btn btn-sm btn-primary-custom">Lihat Semua</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Program Studi</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pendaftarTerbaru as $pendaftar)
                                    <tr>
                                        <td>{{ $pendaftar->name }}</td>
                                        <td>{{ $pendaftar->email }}</td>
                                        <td>{{ $pendaftar->prodi->nama ?? 'Belum memilih' }}</td>
                                        <td>{{ $pendaftar->created_at->format('d M Y') }}</td>
                                        <td>
                                            @if($pendaftar->status == 'pending')
                                                <span class="badge bg-warning">Menunggu</span>
                                            @elseif($pendaftar->status == 'verified')
                                                <span class="badge bg-info">Terverifikasi</span>
                                            @elseif($pendaftar->status == 'accepted')
                                                <span class="badge bg-success">Diterima</span>
                                            @elseif($pendaftar->status == 'rejected')
                                                <span class="badge bg-danger">Ditolak</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.pendaftar.show', $pendaftar->id) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Belum ada data pendaftar</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
