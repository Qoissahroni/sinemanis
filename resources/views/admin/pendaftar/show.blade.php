@extends('admin.layouts.app')

@section('title', 'Detail Pendaftar')

@section('page-title', 'Detail Pendaftar')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Data Pendaftar</h5>
                    <a href="{{ route('admin.pendaftar.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                    <form action="{{ route('admin.pendaftar.destroy', $pendaftar->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pendaftar {{ $pendaftar->name }}? Tindakan ini tidak dapat dibatalkan.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">
                            <i class="fas fa-trash me-1"></i> Hapus
                        </button>
                    </form>
                </div>
                <div class="card-body">
                    <!-- Informasi Dasar -->
                    <div class="table-responsive mb-4">
                        <table class="table table-borderless">
                            <tr>
                                <td colspan="4" class="px-0 pb-0">
                                    <h5 class="border-bottom pb-2 mb-3">Data Pribadi</h5>
                                </td>
                            </tr>
                            <tr>
                                <td width="25%" class="text-muted">Nama Lengkap</td>
                                <td width="25%" class="fw-bold">{{ $pendaftar->name }}</td>
                                <td width="25%" class="text-muted">Email</td>
                                <td width="25%" class="fw-bold">{{ $pendaftar->email }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Tempat Lahir</td>
                                <td class="fw-bold">{{ $pendaftar->tempat_lahir ?? '-' }}</td>
                                <td class="text-muted">Tanggal Lahir</td>
                                <td class="fw-bold">{{ $pendaftar->tanggal_lahir ? $pendaftar->tanggal_lahir->format('d M Y') : '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">NIK</td>
                                <td class="fw-bold">{{ $pendaftar->nik ?? '-' }}</td>
                                <td class="text-muted">NISN</td>
                                <td class="fw-bold">{{ $pendaftar->nisn ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Jenis Kelamin</td>
                                <td class="fw-bold">{{ $pendaftar->jenis_kelamin ?? '-' }}</td>
                                <td class="text-muted">Agama</td>
                                <td class="fw-bold">{{ $pendaftar->agama ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Jenis Pendaftaran</td>
                                <td class="fw-bold">{{ $pendaftar->jenis_pendaftaran ?? '-' }}</td>
                                <td class="text-muted">Nomor Telepon</td>
                                <td class="fw-bold">{{ $pendaftar->phone ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Alamat</td>
                                <td class="fw-bold" colspan="3">{{ $pendaftar->alamat ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Jenis Tinggal</td>
                                <td class="fw-bold">{{ $pendaftar->jenis_tinggal ?? '-' }}</td>
                                <td class="text-muted">Alat Transportasi</td>
                                <td class="fw-bold">{{ $pendaftar->alat_transportasi ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Terima KPS</td>
                                <td class="fw-bold">{{ $pendaftar->kps ?? '-' }}</td>
                                <td class="text-muted">{{ $pendaftar->kps == 'Ya' ? 'No KPS' : '' }}</td>
                                <td class="fw-bold">{{ ($pendaftar->kps == 'Ya') ? ($pendaftar->no_kps ?? '-') : '' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Sudah Bekerja</td>
                                <td class="fw-bold">{{ $pendaftar->bekerja ?? '-' }}</td>
                                <td class="text-muted">{{ $pendaftar->bekerja == 'Ya' ? 'Tempat Kerja' : '' }}</td>
                                <td class="fw-bold">{{ ($pendaftar->bekerja == 'Ya') ? ($pendaftar->tempat_kerja ?? '-') : '' }}</td>
                            </tr>
                            @if($pendaftar->bekerja == 'Ya')
                            <tr>
                                <td class="text-muted">Penghasilan</td>
                                <td class="fw-bold" colspan="3">{{ $pendaftar->penghasilan ?? '-' }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                    
                    <!-- Data Orang Tua/Wali -->
                    <div class="table-responsive mb-4">
                        <table class="table table-borderless">
                            <tr>
                                <td colspan="4" class="px-0 pb-0">
                                    <h5 class="border-bottom pb-2 mb-3">Data Orang Tua/Wali</h5>
                                </td>
                            </tr>
                            <tr>
                                <td width="25%" class="text-muted">NIK Ayah</td>
                                <td width="25%" class="fw-bold">{{ $pendaftar->nik_ayah ?? '-' }}</td>
                                <td width="25%" class="text-muted">Nama Ayah</td>
                                <td width="25%" class="fw-bold">{{ $pendaftar->nama_ayah ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Tanggal Lahir Ayah</td>
                                <td class="fw-bold">{{ $pendaftar->tanggal_lahir_ayah ? date('d M Y', strtotime($pendaftar->tanggal_lahir_ayah)) : '-' }}</td>
                                <td class="text-muted">Pendidikan Ayah</td>
                                <td class="fw-bold">{{ $pendaftar->pendidikan_ayah ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Pekerjaan Ayah</td>
                                <td class="fw-bold">{{ $pendaftar->pekerjaan_ayah ?? '-' }}</td>
                                <td class="text-muted">Penghasilan Ayah</td>
                                <td class="fw-bold">{{ $pendaftar->penghasilan_ayah ?? '-' }}</td>
                            </tr>
                            <tr><td colspan="4" class="py-1"></td></tr>
                            <tr>
                                <td class="text-muted">NIK Ibu</td>
                                <td class="fw-bold">{{ $pendaftar->nik_ibu ?? '-' }}</td>
                                <td class="text-muted">Nama Ibu</td>
                                <td class="fw-bold">{{ $pendaftar->nama_ibu ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Tanggal Lahir Ibu</td>
                                <td class="fw-bold">{{ $pendaftar->tanggal_lahir_ibu ? date('d M Y', strtotime($pendaftar->tanggal_lahir_ibu)) : '-' }}</td>
                                <td class="text-muted">Pekerjaan Ibu</td>
                                <td class="fw-bold">{{ $pendaftar->pekerjaan_ibu ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Penghasilan Ibu</td>
                                <td class="fw-bold" colspan="3">{{ $pendaftar->penghasilan_ibu ?? '-' }}</td>
                            </tr>
                            
                            @if($pendaftar->nama_wali)
                            <tr><td colspan="4" class="py-1"></td></tr>
                            <tr>
                                <td class="text-muted">NIK Wali</td>
                                <td class="fw-bold">{{ $pendaftar->nik_wali ?? '-' }}</td>
                                <td class="text-muted">Nama Wali</td>
                                <td class="fw-bold">{{ $pendaftar->nama_wali ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Tanggal Lahir Wali</td>
                                <td class="fw-bold">{{ $pendaftar->tanggal_lahir_wali ? date('d M Y', strtotime($pendaftar->tanggal_lahir_wali)) : '-' }}</td>
                                <td class="text-muted">Pekerjaan Wali</td>
                                <td class="fw-bold">{{ $pendaftar->pekerjaan_wali ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Penghasilan Wali</td>
                                <td class="fw-bold" colspan="3">{{ $pendaftar->penghasilan_wali ?? '-' }}</td>
                            </tr>
                            @endif
                            
                            <tr><td colspan="4" class="py-1"></td></tr>
                            <tr>
                                <td class="text-muted">Nomor HP Orang Tua/Wali</td>
                                <td class="fw-bold" colspan="3">{{ $pendaftar->no_hp_ortu ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                    
                    <!-- Program Studi Pilihan -->
                    <div class="table-responsive mb-4">
                        <table class="table table-borderless">
                            <tr>
                                <td colspan="4" class="px-0 pb-0">
                                    <h5 class="border-bottom pb-2 mb-3">Program Studi Pilihan</h5>
                                </td>
                            </tr>
                            <tr>
                                <td width="25%" class="text-muted">Program Studi</td>
                                <td width="25%" class="fw-bold">{{ $pendaftar->prodi->nama ?? 'Belum memilih' }}</td>
                                <td width="25%" class="text-muted">Jenjang</td>
                                <td width="25%" class="fw-bold">{{ $pendaftar->prodi->jenjang ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Kelas</td>
                                <td class="fw-bold">{{ $pendaftar->kelas ?? '-' }}</td>
                                <td class="text-muted">Ukuran Almamater</td>
                                <td class="fw-bold">{{ $pendaftar->ukuran_almamater ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Ukuran Kaos PKKMB</td>
                                <td class="fw-bold" colspan="3">{{ $pendaftar->ukuran_kaos ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                    
                    <!-- Data Pendidikan -->
                    <div class="table-responsive mb-4">
                        <table class="table table-borderless">
                            <tr>
                                <td colspan="4" class="px-0 pb-0">
                                    <h5 class="border-bottom pb-2 mb-3">Data Pendidikan</h5>
                                </td>
                            </tr>
                            <tr>
                                <td width="25%" class="text-muted">Asal Sekolah</td>
                                <td width="25%" class="fw-bold">{{ $pendaftar->asal_sekolah ?? '-' }}</td>
                                <td width="25%" class="text-muted">Tahun Lulus</td>
                                <td width="25%" class="fw-bold">{{ $pendaftar->tahun_lulus ?? '-' }}</td>
                            </tr>
                            
                            @if($pendaftar->jenis_pendaftaran == 'Pindahan')
                            <tr>
                                <td class="text-muted">Asal Perguruan Tinggi</td>
                                <td class="fw-bold">{{ $pendaftar->asal_perguruan_tinggi ?? '-' }}</td>
                                <td class="text-muted">Asal Program Studi</td>
                                <td class="fw-bold">{{ $pendaftar->asal_prodi ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Semester Terakhir</td>
                                <td class="fw-bold" colspan="3">{{ $pendaftar->semester_terakhir ?? '-' }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                    
                    <!-- Berkas Pendaftaran -->
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tr>
                                <td colspan="2" class="px-0 pb-0">
                                    <h5 class="border-bottom pb-2 mb-3">Berkas Pendaftaran</h5>
                                </td>
                            </tr>
                            <tr>
                                <td width="30%" class="text-muted">Dokumen Pendaftaran</td>
                                <td width="70%">
                                    @if($pendaftar->berkas_url)
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-file-pdf text-danger me-3 fa-2x"></i>
                                            <div>
                                                <p class="mb-0 fw-bold">Berkas Pendaftaran</p>
                                                <div class="d-flex gap-2 mt-1">
                                                    <a href="{{ route('admin.pendaftar.berkas.view', $pendaftar->id) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-eye me-1"></i> Lihat Dokumen
                                                    </a>
                                                    <a href="{{ route('admin.pendaftar.berkas.download', $pendaftar->id) }}" class="btn btn-sm btn-outline-success">
                                                        <i class="fas fa-download me-1"></i> Unduh
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <p class="mb-0 text-muted fst-italic">Tidak ada berkas pendaftaran yang diunggah atau berkas tidak ditemukan.</p>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted">Pas Foto</td>
                                <td>
                                    @if($pendaftar->foto_url)
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-image text-primary me-3 fa-2x"></i>
                                            <div>
                                                <p class="mb-0 fw-bold">Pas Foto</p>
                                                <div class="d-flex gap-2 mt-1">
                                                    <a href="{{ route('admin.pendaftar.foto.view', $pendaftar->id) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-eye me-1"></i> Lihat Foto
                                                    </a>
                                                    <a href="{{ route('admin.pendaftar.foto.download', $pendaftar->id) }}" class="btn btn-sm btn-outline-success">
                                                        <i class="fas fa-download me-1"></i> Unduh
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Preview Foto -->
                                        <div class="mt-3">
                                            <div class="card" style="max-width: 200px;">
                                                <div class="card-body p-1">
                                                    <img src="{{ route('admin.pendaftar.foto.view', $pendaftar->id) }}" 
                                                         alt="Pas Foto {{ $pendaftar->name }}" 
                                                         class="img-fluid">
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <p class="mb-0 text-muted fst-italic">Tidak ada pas foto yang diunggah atau foto tidak ditemukan.</p>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <!-- Status Pendaftar -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Status Pendaftaran</h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        @if($pendaftar->status == 'pending')
                            <div class="bg-warning text-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width:80px;height:80px">
                                <i class="fas fa-clock fa-2x"></i>
                            </div>
                            <h5>Menunggu Verifikasi</h5>
                        @elseif($pendaftar->status == 'verified')
                            <div class="bg-info text-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width:80px;height:80px">
                                <i class="fas fa-check-circle fa-2x"></i>
                            </div>
                            <h5>Terverifikasi</h5>
                        @elseif($pendaftar->status == 'accepted')
                            <div class="bg-success text-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width:80px;height:80px">
                                <i class="fas fa-user-check fa-2x"></i>
                            </div>
                            <h5>Diterima</h5>
                        @elseif($pendaftar->status == 'rejected')
                            <div class="bg-danger text-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width:80px;height:80px">
                                <i class="fas fa-times-circle fa-2x"></i>
                            </div>
                            <h5>Ditolak</h5>
                        @endif
                    </div>
                    
                    @if($pendaftar->keterangan)
                        <div class="alert alert-light border">
                            <p class="mb-1 text-muted small fw-bold">Keterangan:</p>
                            <p class="mb-0">{{ $pendaftar->keterangan }}</p>
                        </div>
                    @endif
                    
                    <form action="{{ route('admin.pendaftar.update-status', $pendaftar->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="status" class="form-label fw-bold">Ubah Status</label>
                            <select name="status" id="status" class="form-select shadow-none">
                                <option value="pending" {{ $pendaftar->status == 'pending' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                                <option value="verified" {{ $pendaftar->status == 'verified' ? 'selected' : '' }}>Terverifikasi</option>
                                <option value="accepted" {{ $pendaftar->status == 'accepted' ? 'selected' : '' }}>Diterima</option>
                                <option value="rejected" {{ $pendaftar->status == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="keterangan" class="form-label fw-bold">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" class="form-control shadow-none" rows="3" placeholder="Tambahkan keterangan (opsional)">{{ $pendaftar->keterangan }}</textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary-custom w-100">
                            <i class="fas fa-save me-1"></i> Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Info Transaksi -->
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Info Pembayaran</h5>
                </div>
                <div class="card-body">
                    @if($pendaftar->transaksi)
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td class="text-muted ps-0" width="35%">Nomor Transaksi</td>
                                <td class="fw-bold pe-0">{{ $pendaftar->transaksi->nomor_transaksi }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted ps-0">Metode Pembayaran</td>
                                <td class="fw-bold pe-0">{{ $pendaftar->transaksi->metode_pembayaran }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted ps-0">Jumlah</td>
                                <td class="fw-bold pe-0">Rp {{ number_format($pendaftar->transaksi->jumlah, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted ps-0">Tanggal Bayar</td>
                                <td class="fw-bold pe-0">{{ $pendaftar->transaksi->tanggal_bayar->format('d M Y H:i') }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted ps-0">Status</td>
                                <td class="pe-0">
                                    @if($pendaftar->transaksi->status == 'pending')
                                        <span class="badge bg-warning">Menunggu Konfirmasi</span>
                                    @elseif($pendaftar->transaksi->status == 'success')
                                        <span class="badge bg-success">Berhasil</span>
                                    @elseif($pendaftar->transaksi->status == 'failed')
                                        <span class="badge bg-danger">Gagal</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                        
                        
                        @if($pendaftar->transaksi->keterangan)
                            <div class="mt-3">
                                <p class="mb-1 fw-bold">Keterangan Pembayaran:</p>
                                <p class="mb-0 fst-italic">{{ $pendaftar->transaksi->keterangan }}</p>
                            </div>
                        @endif
                        
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-money-bill-wave text-muted fa-3x mb-3"></i>
                            <p class="mb-0">Belum ada data pembayaran</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection