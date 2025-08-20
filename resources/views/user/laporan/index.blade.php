@extends('user.layouts.app')

@section('title', 'Laporan')

@section('page-title', 'Laporan Data Mahasiswa')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Laporan Pendaftaran</h5>
        </div>
        <div class="card-body">
            @if(!$pendaftar)
                <div class="alert alert-warning">
                    <h5><i class="fas fa-exclamation-circle me-2"></i> Formulir Belum Diisi</h5>
                    <p>Anda belum mengisi formulir pendaftaran. Silakan isi formulir terlebih dahulu untuk melihat laporan.</p>
                    <a href="{{ route('user.formulir.index') }}" class="btn btn-primary-custom mt-2">
                        <i class="fas fa-file-alt me-1"></i> Isi Formulir
                    </a>
                </div>
            @else
                <div class="row">
                    <div class="col-md-5 text-center border-end">
                        <div class="p-4">
                            <h5>{{ $pendaftar->name }}</h5>
                            <p class="text-muted mb-2">{{ $pendaftar->prodi->nama ?? 'Belum memilih program studi' }}</p>
                            
                            @if($pendaftar->status == 'pending')
                                <span class="badge bg-warning">Menunggu Verifikasi</span>
                            @elseif($pendaftar->status == 'verified')
                                <span class="badge bg-info">Terverifikasi</span>
                            @elseif($pendaftar->status == 'accepted')
                                <span class="badge bg-success">Diterima</span>
                            @elseif($pendaftar->status == 'rejected')
                                <span class="badge bg-danger">Ditolak</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="col-md-7">
                        <h6 class="border-bottom pb-2 mb-3">Informasi Pendaftaran</h6>
                        
                        <div class="row mb-2">
                            <div class="col-md-4 text-muted">Tanggal Daftar</div>
                            <div class="col-md-8 fw-bold">{{ $pendaftar->created_at->format('d M Y') }}</div>
                        </div>
                        
                        <div class="row mb-2">
                            <div class="col-md-4 text-muted">Program Studi</div>
                            <div class="col-md-8 fw-bold">{{ $pendaftar->prodi->nama ?? '-' }}</div>
                        </div>
                        
                        <div class="row mb-2">
                            <div class="col-md-4 text-muted">Pilihan Kelas</div>
                            <div class="col-md-8 fw-bold">{{ $pendaftar->kelas ?? '-' }}</div>
                        </div>
                        
                        <div class="row mb-2">
                            <div class="col-md-4 text-muted">Status Pembayaran</div>
                            <div class="col-md-8 fw-bold">
                                @if($pendaftar->transaksi)
                                    @if($pendaftar->transaksi->status == 'pending')
                                        <span class="badge bg-warning">Menunggu Konfirmasi</span>
                                    @elseif($pendaftar->transaksi->status == 'success')
                                        <span class="badge bg-success">Pembayaran Diterima</span>
                                    @elseif($pendaftar->transaksi->status == 'failed')
                                        <span class="badge bg-danger">Pembayaran Ditolak</span>
                                    @endif
                                @else
                                    <span class="badge bg-secondary">Belum Melakukan Pembayaran</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="row mb-2">
                            <div class="col-md-4 text-muted">Status Verifikasi</div>
                            <div class="col-md-8 fw-bold">
                                @if($pendaftar->status == 'pending')
                                    <span class="badge bg-warning">Menunggu Verifikasi</span>
                                @elseif($pendaftar->status == 'verified')
                                    <span class="badge bg-info">Terverifikasi</span>
                                @elseif($pendaftar->status == 'accepted')
                                    <span class="badge bg-success">Diterima</span>
                                @elseif($pendaftar->status == 'rejected')
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </div>
                        </div>
                        
                        <h6 class="border-bottom pb-2 mb-3 mt-4">Dokumen Pendaftaran</h6>
                        
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="d-grid gap-2">
                                    @if($pendaftar->transaksi && $pendaftar->transaksi->status == 'success')
                                        <a href="{{ route('user.laporan.bukti-pendaftaran') }}" class="btn btn-primary-custom" target="_blank">
                                            <i class="fas fa-file-alt me-1"></i> Cetak Bukti Pendaftaran
                                        </a>
                                    @else
                                        <button class="btn btn-secondary" disabled>
                                            <i class="fas fa-file-alt me-1"></i> Cetak Bukti Pendaftaran
                                        </button>
                                        <div class="form-text text-center">
                                            Silakan selesaikan pembayaran terlebih dahulu untuk mencetak bukti pendaftaran.
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Data Mahasiswa</h5>
                            </div>
                            <div class="card-body">
                                <div class="accordion" id="accordionData">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingOne">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                <i class="fas fa-user me-2"></i> Data Pribadi
                                            </button>
                                        </h2>
                                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionData">
                                            <div class="accordion-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="row mb-2">
                                                            <div class="col-md-5 text-muted">Nama Lengkap</div>
                                                            <div class="col-md-7 fw-bold">{{ $pendaftar->name }}</div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-md-5 text-muted">Tempat, Tanggal Lahir</div>
                                                            <div class="col-md-7 fw-bold">{{ $pendaftar->tempat_lahir }}, {{ $pendaftar->tanggal_lahir->format('d M Y') }}</div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-md-5 text-muted">Jenis Kelamin</div>
                                                            <div class="col-md-7 fw-bold">{{ $pendaftar->jenis_kelamin }}</div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-md-5 text-muted">NIK</div>
                                                            <div class="col-md-7 fw-bold">{{ $pendaftar->nik }}</div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-md-5 text-muted">Agama</div>
                                                            <div class="col-md-7 fw-bold">{{ $pendaftar->agama }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="row mb-2">
                                                            <div class="col-md-5 text-muted">NISN</div>
                                                            <div class="col-md-7 fw-bold">{{ $pendaftar->nisn }}</div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-md-5 text-muted">Jenis Pendaftaran</div>
                                                            <div class="col-md-7 fw-bold">{{ $pendaftar->jenis_pendaftaran }}</div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-md-5 text-muted">No. HP</div>
                                                            <div class="col-md-7 fw-bold">{{ $pendaftar->phone }}</div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-md-5 text-muted">Email</div>
                                                            <div class="col-md-7 fw-bold">{{ $pendaftar->email }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-md-3 text-muted">Alamat Lengkap</div>
                                                    <div class="col-md-9 fw-bold">{{ $pendaftar->alamat }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingTwo">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                <i class="fas fa-users me-2"></i> Data Orang Tua/Wali
                                            </button>
                                        </h2>
                                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionData">
                                            <div class="accordion-body">
                                                <h6 class="mb-3">Data Ayah</h6>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="row mb-2">
                                                            <div class="col-md-5 text-muted">Nama Ayah</div>
                                                            <div class="col-md-7 fw-bold">{{ $pendaftar->nama_ayah }}</div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-md-5 text-muted">NIK Ayah</div>
                                                            <div class="col-md-7 fw-bold">{{ $pendaftar->nik_ayah }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="row mb-2">
                                                            <div class="col-md-5 text-muted">Pekerjaan</div>
                                                            <div class="col-md-7 fw-bold">{{ $pendaftar->pekerjaan_ayah }}</div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-md-5 text-muted">Penghasilan</div>
                                                            <div class="col-md-7 fw-bold">{{ $pendaftar->penghasilan_ayah }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <h6 class="mb-3 mt-4">Data Ibu</h6>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="row mb-2">
                                                            <div class="col-md-5 text-muted">Nama Ibu</div>
                                                            <div class="col-md-7 fw-bold">{{ $pendaftar->nama_ibu }}</div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-md-5 text-muted">NIK Ibu</div>
                                                            <div class="col-md-7 fw-bold">{{ $pendaftar->nik_ibu }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="row mb-2">
                                                            <div class="col-md-5 text-muted">Pekerjaan</div>
                                                            <div class="col-md-7 fw-bold">{{ $pendaftar->pekerjaan_ibu }}</div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-md-5 text-muted">Penghasilan</div>
                                                            <div class="col-md-7 fw-bold">{{ $pendaftar->penghasilan_ibu }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                @if($pendaftar->nama_wali)
                                                    <h6 class="mb-3 mt-4">Data Wali</h6>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="row mb-2">
                                                                <div class="col-md-5 text-muted">Nama Wali</div>
                                                                <div class="col-md-7 fw-bold">{{ $pendaftar->nama_wali }}</div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-md-5 text-muted">NIK Wali</div>
                                                                <div class="col-md-7 fw-bold">{{ $pendaftar->nik_wali }}</div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="row mb-2">
                                                                <div class="col-md-5 text-muted">Pekerjaan</div>
                                                                <div class="col-md-7 fw-bold">{{ $pendaftar->pekerjaan_wali }}</div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-md-5 text-muted">Penghasilan</div>
                                                                <div class="col-md-7 fw-bold">{{ $pendaftar->penghasilan_wali }}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                                
                                                <div class="row mt-3">
                                                    <div class="col-md-3 text-muted">No. HP Orang Tua/Wali</div>
                                                    <div class="col-md-9 fw-bold">{{ $pendaftar->no_hp_ortu }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingThree">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                <i class="fas fa-graduation-cap me-2"></i> Data Pendidikan
                                            </button>
                                        </h2>
                                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionData">
                                            <div class="accordion-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="row mb-2">
                                                            <div class="col-md-5 text-muted">Asal Sekolah</div>
                                                            <div class="col-md-7 fw-bold">{{ $pendaftar->asal_sekolah }}</div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-md-5 text-muted">Tahun Lulus</div>
                                                            <div class="col-md-7 fw-bold">{{ $pendaftar->tahun_lulus }}</div>
                                                        </div>
                                                    </div>
                                                    
                                                    @if($pendaftar->jenis_pendaftaran == 'Pindahan')
                                                        <div class="col-md-6">
                                                            <div class="row mb-2">
                                                                <div class="col-md-5 text-muted">Asal Perguruan Tinggi</div>
                                                                <div class="col-md-7 fw-bold">{{ $pendaftar->asal_perguruan_tinggi }}</div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-md-5 text-muted">Asal Program Studi</div>
                                                                <div class="col-md-7 fw-bold">{{ $pendaftar->asal_prodi }}</div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-md-5 text-muted">Semester Terakhir</div>
                                                                <div class="col-md-7 fw-bold">{{ $pendaftar->semester_terakhir }}</div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection