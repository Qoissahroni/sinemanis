@extends('admin.layouts.app')

@section('title', 'Detail Transaksi')

@section('page-title', 'Detail Transaksi')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Detail Transaksi</h5>
                    <a href="{{ route('admin.transaksi.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="mb-1 text-muted small">Nomor Transaksi</p>
                            <p class="mb-3 fw-bold">{{ $transaksi->nomor_transaksi }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1 text-muted small">Status</p>
                            <p class="mb-3">
                                @if($transaksi->status == 'pending')
                                    <span class="badge bg-warning">Menunggu Konfirmasi</span>
                                @elseif($transaksi->status == 'success')
                                    <span class="badge bg-success">Berhasil</span>
                                @elseif($transaksi->status == 'failed')
                                    <span class="badge bg-danger">Gagal</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="mb-1 text-muted small">Jumlah Pembayaran</p>
                            <p class="mb-3 fw-bold">Rp {{ number_format($transaksi->jumlah, 0, ',', '.') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1 text-muted small">Tanggal Pembayaran</p>
                            <p class="mb-3 fw-bold">{{ optional($transaksi->tanggal_bayar)->format('d M Y H:i') ?? '-' }}</p>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="mb-1 text-muted small">Metode Pembayaran</p>
                            <p class="mb-3 fw-bold">{{ $transaksi->metode_pembayaran ?? 'Transfer Bank' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1 text-muted small">Keterangan</p>
                            <p class="mb-3">{{ $transaksi->keterangan ?? '-' }}</p>
                        </div>
                    </div>
                    
                    @if($transaksi->bukti_bayar_url)
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <p class="mb-1 text-muted small">Bukti Pembayaran</p>
                            <div class="card mt-2">
                                <div class="card-body">
                                    <div class="text-center">
                                        @php
                                            $fileExtension = pathinfo($transaksi->bukti_bayar_url, PATHINFO_EXTENSION);
                                            $isImage = in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif']);
                                        @endphp
                                        
                                        @if($isImage)
                                        <img src="{{ asset('storage/' . $transaksi->bukti_bayar_url) }}" alt="Bukti Pembayaran"
                                        class="img-fluid mb-3" style="max-height: 400px;">
                                        @endif
                                    
                                        <div class="mt-3">
                                            <a href="{{ route('admin.transaksi.download', $transaksi->id) }}" class="btn btn-success">
                                                <i class="fas fa-download me-1"></i> Download Bukti Pembayaran
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i> Tidak ada bukti pembayaran yang diunggah.
                    </div>
                @endif
                </div>
            </div>
            

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Data Pendaftar</h5>
                </div>
                <div class="card-body">
                    @if($transaksi->pendaftar)
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p class="mb-1 text-muted small">Nama Lengkap</p>
                                <p class="mb-3 fw-bold">{{ $transaksi->pendaftar->name }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1 text-muted small">Email</p>
                                <p class="mb-3 fw-bold">{{ $transaksi->pendaftar->email }}</p>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p class="mb-1 text-muted small">Program Studi</p>
                                <p class="mb-3 fw-bold">{{ $transaksi->pendaftar->prodi->nama ?? 'Belum memilih' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1 text-muted small">Status Pendaftaran</p>
                                <p class="mb-3">
                                    @if($transaksi->pendaftar->status == 'pending')
                                        <span class="badge bg-warning">Menunggu</span>
                                    @elseif($transaksi->pendaftar->status == 'verified')
                                        <span class="badge bg-info">Terverifikasi</span>
                                    @elseif($transaksi->pendaftar->status == 'accepted')
                                        <span class="badge bg-success">Diterima</span>
                                    @elseif($transaksi->pendaftar->status == 'rejected')
                                        <span class="badge bg-danger">Ditolak</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        
                        <div class="text-center">
                            <a href="{{ route('admin.pendaftar.show', $transaksi->pendaftar->id) }}" class="btn btn-primary-custom">
                                <i class="fas fa-user me-1"></i> Lihat Detail Pendaftar
                            </a>
                        </div>
                    @else
                        <div class="text-center py-3">
                            <i class="fas fa-user-slash text-muted fa-2x mb-3"></i>
                            <p>Data pendaftar tidak ditemukan</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <!-- Status Transaksi -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Konfirmasi Pembayaran</h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        @if($transaksi->status == 'pending')
                            <div class="bg-warning text-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width:70px;height:70px">
                                <i class="fas fa-clock fa-2x"></i>
                            </div>
                            <h5>Menunggu Konfirmasi</h5>
                        @elseif($transaksi->status == 'success')
                            <div class="bg-success text-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width:70px;height:70px">
                                <i class="fas fa-check-circle fa-2x"></i>
                            </div>
                            <h5>Pembayaran Berhasil</h5>
                        @elseif($transaksi->status == 'failed')
                            <div class="bg-danger text-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width:70px;height:70px">
                                <i class="fas fa-times-circle fa-2x"></i>
                            </div>
                            <h5>Pembayaran Gagal</h5>
                        @endif
                    </div>
                    
                    <form action="{{ route('admin.transaksi.update-status', $transaksi->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="status" class="form-label">Ubah Status</label>
                            <select name="status" id="status" class="form-select">
                                <option value="pending" {{ $transaksi->status == 'pending' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                                <option value="success" {{ $transaksi->status == 'success' ? 'selected' : '' }}>Pembayaran Berhasil</option>
                                <option value="failed" {{ $transaksi->status == 'failed' ? 'selected' : '' }}>Pembayaran Gagal</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" class="form-control" rows="3">{{ $transaksi->keterangan }}</textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary-custom w-100">
                            <i class="fas fa-save me-1"></i> Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Riwayat Status -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">Riwayat Status</h5>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @if($transaksi->created_at)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-plus-circle text-primary me-2"></i>
                                    <span>Transaksi Dibuat</span>
                                </div>
                                <span class="text-muted small">{{ $transaksi->created_at->format('d M Y H:i') }}</span>
                            </li>
                        @endif
                        
                        @if($transaksi->status_updated_at)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-sync-alt text-info me-2"></i>
                                    <span>Status Diperbarui</span>
                                </div>
                                <span class="text-muted small">
                                    @if(is_string($transaksi->status_updated_at))
                                        {{ $transaksi->status_updated_at }}
                                    @else
                                        {{ $transaksi->status_updated_at->format('d M Y H:i') }}
                                    @endif
                                </span>
                            </li>
                        @endif
                        
                        @if($transaksi->status == 'success')
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    <span>Pembayaran Berhasil</span>
                                </div>
                                <span class="text-muted small">{{ $transaksi->updated_at->format('d M Y H:i') }}</span>
                            </li>
                        @elseif($transaksi->status == 'failed')
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-times-circle text-danger me-2"></i>
                                    <span>Pembayaran Gagal</span>
                                </div>
                                <span class="text-muted small">{{ $transaksi->updated_at->format('d M Y H:i') }}</span>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection