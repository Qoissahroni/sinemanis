@extends('user.layouts.app')

@section('title', 'Pembayaran Selisih')

@section('page-title', 'Pembayaran Selisih Prodi')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Informasi Pembayaran Selisih</h5>
    </div>
    <div class="card-body">
        @if($transaksi && $transaksi->metode_pembayaran)
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
                                <p>{{ optional($transaksi->tanggal_bayar)->format('d M Y') ?? '-' }}</p>
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
            </div>
        @elseif($transaksi)
            <div class="row">
                <div class="col-md-6">
                    <div class="alert alert-info mb-4">
                        <h5><i class="fas fa-info-circle me-2"></i> Selisih yang harus dibayar</h5>
                        <h4 class="text-primary mt-3 mb-3">Rp {{ number_format($biaya, 0, ',', '.') }}</h4>
                        <p class="mb-0">Silakan lakukan pembayaran melalui metode di bawah ini.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <form action="{{ route('user.pembayaran-selisih.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                            <select class="form-select" id="metode_pembayaran" name="metode_pembayaran" required>
                                <option value="">Pilih Metode</option>
                                <option value="Transfer Bank">Transfer Bank</option>
                                <option value="QRIS">QRIS</option>
                                <option value="Cash">Cash</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_bayar" class="form-label">Tanggal Pembayaran</label>
                            <input type="date" class="form-control" id="tanggal_bayar" name="tanggal_bayar" required>
                        </div>
                        <div class="mb-3">
                            <label for="bukti_bayar" class="form-label">Bukti Pembayaran</label>
                            <input type="file" class="form-control" id="bukti_bayar" name="bukti_bayar">
                            <div class="form-text">Wajib diisi untuk Transfer Bank atau QRIS.</div>
                        </div>
                        <button type="submit" class="btn btn-primary-custom">Kirim Konfirmasi</button>
                    </form>
                </div>
            </div>
        @else
            <div class="alert alert-info">Tidak ada pembayaran selisih yang perlu dilakukan.</div>
        @endif
    </div>
</div>
@endsection