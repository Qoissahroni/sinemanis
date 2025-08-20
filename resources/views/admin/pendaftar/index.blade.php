@extends('admin.layouts.app')

@section('title', 'Manajemen Pendaftaran')

@section('page-title', 'Manajemen Pendaftaran')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>Daftar Pendaftar</h5>
        </div>
        <div class="card-body">
            <!-- Filter dan Pencarian -->
            <form action="{{ route('admin.pendaftar.index') }}" method="GET" class="mb-4">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                            <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Terverifikasi</option>
                            <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>Diterima</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="prodi_id" class="form-label">Program Studi</label>
                        <select name="prodi_id" id="prodi_id" class="form-select">
                            <option value="">Semua Program Studi</option>
                            @foreach($prodis as $prodi)
                                <option value="{{ $prodi->id }}" {{ request('prodi_id') == $prodi->id ? 'selected' : '' }}>
                                    {{ $prodi->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="search" class="form-label">Cari</label>
                        <input type="text" class="form-control" id="search" name="search" placeholder="Cari nama atau email..." value="{{ request('search') }}">
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
                            <th>No</th>
                            <th>Nama Lengkap</th>
                            <th>Email</th>
                            <th>Program Studi</th>
                            <th>Tanggal Daftar</th>
                            <th>Status</th>
                            <th>Pergantian Prodi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pendaftars as $index => $pendaftar)
                            <tr>
                                <td>{{ $index + $pendaftars->firstItem() }}</td>
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
                                <!-- TAMBAH KOLOM PERGANTIAN PRODI INI -->
                                <td>
                                    @if($pendaftar->status_ganti_prodi == 'pending')
                                        <div class="d-flex gap-1 mb-1">
                                            <form action="{{ route('admin.pendaftar.approve-ganti-prodi', $pendaftar->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-sm btn-success" title="Setujui" onclick="return confirm('Setujui pergantian prodi?')">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.pendaftar.reject-ganti-prodi', $pendaftar->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Tolak" onclick="return confirm('Tolak pergantian prodi?')">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        </div>
                                        <small class="text-muted d-block">Ke: {{ $pendaftar->prodiBaru->nama ?? '' }}</small>
                                    @elseif($pendaftar->status_ganti_prodi == 'approved')
                                        <span class="badge bg-success">Disetujui</span>
                                    @elseif($pendaftar->status_ganti_prodi == 'rejected')
                                        <span class="badge bg-danger">Ditolak</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <!-- END TAMBAHAN -->
                                <td>
                                    <a href="{{ route('admin.pendaftar.show', $pendaftar->id) }}" class="btn btn-sm btn-info mb-1">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                    <form action="{{ route('admin.pendaftar.destroy', $pendaftar->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pendaftar {{ $pendaftar->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger mb-1">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data pendaftar yang ditemukan</td> <!-- UBAH COLSPAN JADI 8 -->
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $pendaftars->appends(request()->query())->links('pagination::simple-bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection