@extends('admin.layouts.app')

@section('title', 'Data Transaksi')

@section('page-title', 'Data Transaksi')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>Daftar Transaksi</h5>
        </div>
        <div class="card-body">
            <!-- Filter dan Pencarian -->
            <form action="{{ route('admin.transaksi.index') }}" method="GET" class="mb-4">
                <div class="row g-3">
                    <div class="col-md-2">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                            <option value="success" {{ request('status') == 'success' ? 'selected' : '' }}>Berhasil</option>
                            <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Gagal</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="start_date" class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-2">
                        <label for="end_date" class="form-label">Tanggal Akhir</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request('end_date') }}">
                    </div>
                    <div class="col-md-4">
                        <label for="search" class="form-label">Cari</label>
                        <input type="text" class="form-control" id="search" name="search" placeholder="Cari nomor transaksi atau nama..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary-custom w-100">
                            <i class="fas fa-search me-1"></i> Filter
                        </button>
                    </div>
                </div>
            </form>
            
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nomor Transaksi</th>
                            <th>Nama Pendaftar</th>
                            <th>Jumlah</th>
                            <th>Tanggal Bayar</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transaksis as $index => $transaksi)
                            <tr>
                                <td>{{ $index + $transaksis->firstItem() }}</td>
                                <td>{{ $transaksi->nomor_transaksi }}</td>
                                <td>{{ $transaksi->pendaftar->name ?? 'N/A' }}</td>
                                <td>Rp {{ number_format($transaksi->jumlah, 0, ',', '.') }}</td>
                                <td>{{ optional($transaksi->tanggal_bayar)->format('d M Y H:i') ?? '-' }}</td>
                                <td>
                                    @if($transaksi->status == 'pending')
                                        <span class="badge bg-warning">Menunggu</span>
                                    @elseif($transaksi->status == 'success')
                                        <span class="badge bg-success">Berhasil</span>
                                    @elseif($transaksi->status == 'failed')
                                        <span class="badge bg-danger">Gagal</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.transaksi.show', $transaksi->id) }}" class="btn btn-sm btn-info mb-1">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data transaksi yang ditemukan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $transaksis->appends(request()->query())->links('pagination::simple-bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection