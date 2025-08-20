@extends('user.layouts.app')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard Mahasiswa')

@section('content')
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">Status Pendaftaran</h5>
                </div>
                <div class="card-body text-center">
                    @if($pendaftar && $pendaftar->status)
                        @if($pendaftar->status == 'pending')
                            <div class="bg-warning text-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width:80px;height:80px">
                                <i class="fas fa-clock fa-2x"></i>
                            </div>
                            <h5>Menunggu Verifikasi</h5>
                            <p class="text-muted">Formulir Anda sedang dalam proses verifikasi.</p>
                        @elseif($pendaftar->status == 'verified')
                            <div class="bg-info text-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width:80px;height:80px">
                                <i class="fas fa-check-circle fa-2x"></i>
                            </div>
                            <h5>Terverifikasi</h5>
                            <p class="text-muted">Data Anda telah diverifikasi. Silakan cek hasil seleksi.</p>
                        @elseif($pendaftar->status == 'accepted')
                            <div class="bg-success text-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width:80px;height:80px">
                                <i class="fas fa-user-check fa-2x"></i>
                            </div>
                            <h5>Diterima</h5>
                            <p class="text-muted">Selamat! Anda diterima di program studi {{ $pendaftar->prodi->nama ?? '' }}.</p>
                        @elseif($pendaftar->status == 'rejected')
                            <div class="bg-danger text-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width:80px;height:80px">
                                <i class="fas fa-times-circle fa-2x"></i>
                            </div>
                            <h5>Ditolak</h5>
                            <p class="text-muted">Maaf, pendaftaran Anda belum bisa diterima.</p>
                        @endif
                    @else
                        <div class="bg-secondary text-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width:80px;height:80px">
                            <i class="fas fa-exclamation-triangle fa-2x"></i>
                        </div>
                        <h5>Belum Mendaftar</h5>
                        <p class="text-muted">Anda belum mengisi formulir pendaftaran.</p>
                        <a href="{{ route('user.formulir.index') }}" class="btn btn-primary-custom">
                            <i class="fas fa-file-alt me-1"></i> Isi Formulir
                        </a>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-8 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">Timeline Pendaftaran</h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item {{ $timelineStatus['register'] }} mb-4">
                            <h5>Pendaftaran Akun</h5>
                            <p class="text-muted mb-0">
                                {{ $timelineStatus['register'] == 'completed' ? 'Selesai pada ' . auth()->user()->created_at->format('d M Y') : 'Belum selesai' }}
                            </p>
                        </div>
                        
                        <div class="timeline-item {{ $timelineStatus['formulir'] }} mb-4">
                            <h5>Pengisian Formulir</h5>
                            <p class="text-muted mb-0">
                                @if($timelineStatus['formulir'] == 'completed')
                                    Selesai pada {{ $pendaftar->created_at->format('d M Y') }}
                                @elseif($timelineStatus['formulir'] == 'active')
                                    Sedang berlangsung
                                @else
                                    Belum dimulai
                                @endif
                            </p>
                        </div>
                        
                        <div class="timeline-item {{ $timelineStatus['payment'] }} mb-4">
                            <h5>Pembayaran Biaya Pendaftaran</h5>
                            <p class="text-muted mb-0">
                                @if($timelineStatus['payment'] == 'completed')
                                    Selesai pada {{ $pendaftar->transaksi->updated_at->format('d M Y') }}
                                @elseif($timelineStatus['payment'] == 'active')
                                    Menunggu konfirmasi pembayaran
                                @else
                                    Belum melakukan pembayaran
                                @endif
                            </p>
                        </div>
                        
                        <div class="timeline-item {{ $timelineStatus['verification'] }} mb-4">
                            <h5>Verifikasi Data</h5>
                            <p class="text-muted mb-0">
                                @if($timelineStatus['verification'] == 'completed')
                                    Terverifikasi
                                @elseif($timelineStatus['verification'] == 'active')
                                    Sedang dalam proses verifikasi
                                @else
                                    Belum diverifikasi
                                @endif
                            </p>
                        </div>
                        
                        <div class="timeline-item {{ $timelineStatus['result'] }}">
                            <h5>Pengumuman Hasil</h5>
                            <p class="text-muted mb-0">
                                @if($timelineStatus['result'] == 'completed')
                                    @if($pendaftar->status == 'accepted')
                                        Selamat! Anda diterima di program studi {{ $pendaftar->prodi->nama ?? '' }}
                                    @elseif($pendaftar->status == 'rejected')
                                        Maaf, Anda belum bisa diterima
                                    @endif
                                @elseif($timelineStatus['result'] == 'active')
                                    Sedang menunggu pengumuman
                                @else
                                    Belum ada pengumuman
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @if($pendaftar && $pendaftar->status == 'accepted')
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="fas fa-check-circle me-2"></i> Selamat! Anda diterima di Universitas Selamat Sri</h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-custom">
                            <h5>Informasi Penting</h5>
                            <p>Silakan cetak kartu mahasiswa dan bukti pendaftaran Anda dari menu Laporan. Bawa dokumen tersebut saat melakukan daftar ulang.</p>
                        </div>
                        
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <h6><strong>Program Studi</strong></h6>
                                <p>{{ $pendaftar->prodi->nama ?? '' }} ({{ $pendaftar->prodi->jenjang ?? '' }})</p>
                                
                                <h6><strong>Kelas</strong></h6>
                                <p>{{ $pendaftar->kelas ?? '' }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6><strong>Tahap Selanjutnya:</strong></h6>
                                <ol>
                                    <li>Lakukan daftar ulang pada tanggal 10-20 Agustus 2025</li>
                                    <li>Ikuti kegiatan PKKMB pada tanggal 25-30 Agustus 2025</li>
                                    <li>Persiapkan dokumen asli yang diperlukan</li>
                                </ol>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end mt-3">
                            <a href="{{ route('user.laporan.index') }}" class="btn btn-primary-custom">
                                <i class="fas fa-print me-1"></i> Cetak Bukti Pendaftaran
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection