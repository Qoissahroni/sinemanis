@extends('user.layouts.app')

@section('title', 'Pembayaran')

@section('page-title', 'Pembayaran Pendaftaran')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Informasi Pembayaran</h5>
        </div>
        <div class="card-body">
            @if($transaksi)
                <div class="row">
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Detail Transaksi</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <p class="fw-bold mb-1">Nomor Transaksi:</p>
                                    <p>{{ $transaksi->nomor_transaksi }}</p>
                                </div>
                                
                                <div class="mb-3">
                                    <p class="fw-bold mb-1">Tanggal Pembayaran:</p>
                                    <p>{{ $transaksi->tanggal_bayar->format('d M Y') }}</p>
                                </div>
                                
                                <div class="mb-3">
                                    <p class="fw-bold mb-1">Metode Pembayaran:</p>
                                    <p>{{ $transaksi->metode_pembayaran }}</p>
                                </div>
                                
                                <div class="mb-3">
                                    <p class="fw-bold mb-1">Jumlah:</p>
                                    <p class="text-primary fw-bold">Rp {{ number_format($transaksi->jumlah, 0, ',', '.') }}</p>
                                </div>
                                
                                <div class="mb-3">
                                    <p class="fw-bold mb-1">Status:</p>
                                    @if($transaksi->status == 'pending')
                                        <span class="badge bg-warning">Menunggu Konfirmasi</span>
                                    @elseif($transaksi->status == 'success')
                                        <span class="badge bg-success">Pembayaran Berhasil</span>
                                    @elseif($transaksi->status == 'failed')
                                        <span class="badge bg-danger">Pembayaran Gagal</span>
                                    @endif
                                </div>
                                
                                {{-- UPDATE - Tampilkan bukti bayar untuk Transfer Bank dan QRIS --}}
                                @if(in_array($transaksi->metode_pembayaran, ['Transfer Bank', 'QRIS']) && $transaksi->bukti_bayar_url)
                                    <div class="mb-3">
                                        <p class="fw-bold mb-1">Bukti Pembayaran:</p>
                                        <a href="{{ asset('storage/' . $transaksi->bukti_bayar_url) }}" target="_blank" class="btn btn-sm btn-primary-custom">
                                            <i class="fas fa-file-image me-1"></i> Lihat Bukti Pembayaran
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Status Pembayaran</h5>
                            </div>
                            <div class="card-body text-center">
                                @if($transaksi->status == 'pending')
                                    <div class="bg-warning text-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width:80px;height:80px">
                                        <i class="fas fa-clock fa-2x"></i>
                                    </div>
                                    <h5>Menunggu Konfirmasi</h5>
                                    <p class="text-muted">Pembayaran Anda sedang diverifikasi oleh admin. Mohon tunggu.</p>
                                @elseif($transaksi->status == 'success')
                                    <div class="bg-success text-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width:80px;height:80px">
                                        <i class="fas fa-check-circle fa-2x"></i>
                                    </div>
                                    <h5>Pembayaran Berhasil</h5>
                                    <p class="text-muted">Pembayaran Anda telah diverifikasi. Proses pendaftaran akan dilanjutkan.</p>
                                @elseif($transaksi->status == 'failed')
                                    <div class="bg-danger text-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width:80px;height:80px">
                                        <i class="fas fa-times-circle fa-2x"></i>
                                    </div>
                                    <h5>Pembayaran Gagal</h5>
                                    <p class="text-muted">Pembayaran Anda tidak diverifikasi. Silakan hubungi admin untuk informasi lebih lanjut.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-md-7">
                        <div class="alert alert-info mb-4">
                            <h5><i class="fas fa-info-circle me-2"></i> Informasi Biaya Pendaftaran</h5>
                            <p>Biaya pendaftaran untuk program studi {{ $pendaftar->prodi->nama ?? 'yang dipilih' }} adalah:</p>
                            <h4 class="text-primary mt-3 mb-3">Rp {{ number_format($biaya, 0, ',', '.') }}</h4>
                            <hr>
                            <h6 class="mt-3">INFO BIAYA:</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>TEKNIK:</strong>
                                    <ul class="mb-3">
                                        <li>Pendaftaran: Rp 250,000</li>
                                        <li>Daftar Ulang: Rp 715,000</li>
                                        <li>PKKMB: Rp 450,000</li>
                                        <li><strong>Total: Rp 1,415,000</strong></li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <strong>NON-TEKNIK:</strong>
                                    <ul class="mb-3">
                                        <li>Pendaftaran: Rp 250,000</li>
                                        <li>Daftar Ulang: Rp 665,000</li>
                                        <li>PKKMB: Rp 450,000</li>
                                        <li><strong>Total: Rp 1,365,000</strong></li>
                                    </ul>
                                </div>
                            </div>
                            <p class="mb-0">Silakan lakukan pembayaran melalui metode di bawah ini.</p>
                        </div>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Metode Pembayaran</h5>
                            </div>
                            <div class="card-body">
                                <div class="accordion" id="accordionPembayaran">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingOne">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                <i class="fas fa-university me-2"></i> Transfer Bank
                                            </button>
                                        </h2>
                                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionPembayaran">
                                            <div class="accordion-body">
                                                <p>Silakan transfer ke rekening berikut:</p>
                                                <ul class="list-group mb-3">
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        <span>Bank BNI</span>
                                                        <span class="fw-bold">1514931473 (Pendaftaran)</span>
                                                    </li>
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        <span>Bank BNI</span>
                                                        <span class="fw-bold">1807504595 (Daftar Ulang)</span>
                                                    </li>
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        <span>Bank BNI</span>
                                                        <span class="fw-bold">1887828663 (PKKMB)</span>
                                                    </li>
                                                </ul>
                                                <p class="mb-0">Atas nama: <strong>Universitas Selamat Sri</strong></p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    {{-- UPDATE - Accordion untuk QRIS --}}
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingQRIS">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseQRIS" aria-expanded="false" aria-controls="collapseQRIS">
                                                <i class="fas fa-qrcode me-2"></i> QRIS (QR Code Indonesian Standard)
                                            </button>
                                        </h2>
                                        <div id="collapseQRIS" class="accordion-collapse collapse" aria-labelledby="headingQRIS" data-bs-parent="#accordionPembayaran">
                                            <div class="accordion-body">
                                                @if(isset($qrCodeUrl) && $qrCodeUrl)
                                                    <div class="alert alert-info mb-3">
                                                        <h6><i class="fas fa-info-circle me-1"></i> Tentang QRIS</h6>
                                                        <p class="mb-0">QRIS adalah standar QR Code Indonesia yang dapat digunakan dengan semua aplikasi e-wallet dan mobile banking di Indonesia seperti GoPay, OVO, DANA, ShopeePay, LinkAja, BCA Mobile, BRI Mobile, dan lainnya.</p>
                                                    </div>
                                                    
                                                    <div class="alert alert-warning">
                                                        <h6><i class="fas fa-mobile-alt me-1"></i> Cara Pembayaran QRIS:</h6>
                                                        <ol class="mb-0">
                                                            <li>Pilih metode "QRIS" di form pembayaran sebelah kanan</li>
                                                            <li>Klik "Tampilkan QR Code QRIS"</li>
                                                            <li>Scan QR Code dengan aplikasi e-wallet atau mobile banking favorit Anda</li>
                                                            <li>Lakukan pembayaran di aplikasi</li>
                                                            <li>Screenshot bukti pembayaran yang berhasil</li>
                                                            <li>Upload screenshot sebagai bukti pembayaran</li>
                                                        </ol>
                                                    </div>
                                                    
                                                    <div class="text-center">
                                                        <p class="text-muted">Compatible dengan:</p>
                                                        <div class="row text-center">
                                                            <div class="col-4 mb-2">
                                                                <span class="badge bg-primary">GoPay</span>
                                                            </div>
                                                            <div class="col-4 mb-2">
                                                                <span class="badge bg-success">DANA</span>
                                                            </div>
                                                            <div class="col-4 mb-2">
                                                                <span class="badge bg-warning">OVO</span>
                                                            </div>
                                                            <div class="col-4 mb-2">
                                                                <span class="badge bg-danger">ShopeePay</span>
                                                            </div>
                                                            <div class="col-4 mb-2">
                                                                <span class="badge bg-info">LinkAja</span>
                                                            </div>
                                                            <div class="col-4 mb-2">
                                                                <span class="badge bg-dark">Dan lainnya</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="alert alert-info">
                                                        <p class="mb-0">QR Code QRIS akan ditampilkan setelah Anda memilih metode pembayaran QRIS di form sebelah kanan.</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingTwo">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                <i class="fas fa-money-bill-wave me-2"></i> Pembayaran Tunai
                                            </button>
                                        </h2>
                                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionPembayaran">
                                            <div class="accordion-body">
                                                <p>Anda dapat melakukan pembayaran tunai di gedung PMB Universitas Selamat Sri.</p>
                                                <p class="mb-0">Alamat: <strong>Jl. Raya Batang-Semarang Km.14 Clapar, Subah, Batang, Jawa Tengah.</strong></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-5">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Konfirmasi Pembayaran</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('user.pembayaran.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    
                                    <div class="mb-3">
                                        <label class="form-label required-field">Metode Pembayaran</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="metode_pembayaran" id="metode_transfer" value="Transfer Bank" checked>
                                            <label class="form-check-label" for="metode_transfer">
                                                Transfer Bank
                                            </label>
                                        </div>
                                        {{-- UPDATE - Radio button untuk QRIS --}}
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="metode_pembayaran" id="metode_qris" value="QRIS">
                                            <label class="form-check-label" for="metode_qris">
                                                QRIS (QR Code Indonesian Standard)
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="metode_pembayaran" id="metode_cash" value="Cash">
                                            <label class="form-check-label" for="metode_cash">
                                                Pembayaran Tunai
                                            </label>
                                        </div>
                                        @error('metode_pembayaran')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="tanggal_bayar" class="form-label required-field">Tanggal Pembayaran</label>
                                        <input type="date" class="form-control @error('tanggal_bayar') is-invalid @enderror" id="tanggal_bayar" name="tanggal_bayar" value="{{ old('tanggal_bayar', date('Y-m-d')) }}" required>
                                        @error('tanggal_bayar')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3" id="bukti_bayar_section">
                                        <label for="bukti_bayar" class="form-label required-field">Upload Bukti Pembayaran</label>
                                        <input type="file" class="form-control @error('bukti_bayar') is-invalid @enderror" id="bukti_bayar" name="bukti_bayar" accept=".jpg,.jpeg,.png,.pdf">
                                        @error('bukti_bayar')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">Format: JPG, PNG, atau PDF (Maks. 5MB)</div>
                                    </div>
                                    
                                    {{-- UPDATE - Container untuk QRIS --}}
                                    <div class="mb-3" id="qris_section" style="display: none;">
                                        <div class="alert alert-info">
                                            <h6><i class="fas fa-qrcode me-1"></i> QR Code QRIS</h6>
                                            <div id="qris-container" class="text-center">
                                                <button type="button" id="show-qris-btn" class="btn btn-primary-custom">
                                                    <i class="fas fa-qrcode me-1"></i> Tampilkan QR Code QRIS
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="d-grid mt-4">
                                        <button type="submit" class="btn btn-primary-custom">
                                            <i class="fas fa-paper-plane me-1"></i> Kirim Konfirmasi
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
{{-- Script Midtrans Snap jika QR Code diaktifkan --}}
@if(config('midtrans.client_key'))
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const metodeTransfer = document.getElementById('metode_transfer');
        const metodeQRIS = document.getElementById('metode_qris'); // UPDATE
        const metodeCash = document.getElementById('metode_cash');
        const buktiBayarSection = document.getElementById('bukti_bayar_section');
        const qrisSection = document.getElementById('qris_section'); // UPDATE
        const showQrisBtn = document.getElementById('show-qris-btn'); // UPDATE
        
        // QRIS snap token
        const snapToken = @json($qrCodeUrl ?? null);
        
        if (metodeTransfer && metodeCash && buktiBayarSection) {
            metodeTransfer.addEventListener('change', function() {
                buktiBayarSection.style.display = 'block';
                if (qrisSection) qrisSection.style.display = 'none';
            });
            
            // UPDATE - Handler untuk QRIS
            if (metodeQRIS && qrisSection) {
                metodeQRIS.addEventListener('change', function() {
                    buktiBayarSection.style.display = 'block';
                    qrisSection.style.display = 'block';
                });
            }
            
            metodeCash.addEventListener('change', function() {
                buktiBayarSection.style.display = 'none';
                if (qrisSection) qrisSection.style.display = 'none';
            });
            
            // UPDATE - Handler untuk show QRIS
            if (showQrisBtn && snapToken && typeof snap !== 'undefined') {
                showQrisBtn.addEventListener('click', function() {
                    snap.pay(snapToken, {
                        onSuccess: function(result) {
                            alert("Pembayaran QRIS berhasil!");
                            console.log(result);
                        },
                        onPending: function(result) {
                            alert("Menunggu pembayaran QRIS!");
                            console.log(result);
                        },
                        onError: function(result) {
                            alert("Pembayaran QRIS gagal!");
                            console.log(result);
                        }
                    });
                });
            }
        }
    });
</script>
@endpush