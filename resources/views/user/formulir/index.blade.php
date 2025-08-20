@extends('user.layouts.app')

@section('title', 'Formulir Pendaftaran')

@section('page-title', 'Formulir Pendaftaran')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Formulir Penerimaan Mahasiswa Baru</h5>
        </div>
        <div class="card-body">
            @if($isSubmitted)
            <div class="alert alert-success">
                <h5><i class="fas fa-check-circle me-2"></i> Formulir Pendaftaran Telah Diisi</h5>
                <p>Anda telah mengisi formulir pendaftaran. Silakan lanjutkan ke tahap pembayaran atau cetak bukti pendaftaran Anda.</p>
                <div class="mt-3">
                    <a href="{{ route('user.pembayaran.index') }}" class="btn btn-primary-custom me-2">
                        <i class="fas fa-money-bill-wave me-1"></i> Lanjut ke Pembayaran
                    </a>
                    <a href="{{ route('user.laporan.index') }}" class="btn btn-accent-custom me-2">
                        <i class="fas fa-print me-1"></i> Cetak Bukti Pendaftaran
                    </a>
                </div>
            </div>

              <!-- Section Pergantian Prodi -->
              @if(!$pendaftar->sudah_ganti_prodi)
              <div class="card mt-4">
                  <div class="card-header bg-light">
                      <h5 class="mb-0"><i class="fas fa-exchange-alt me-2"></i>Pergantian Program Studi <span class="text-muted small">(Opsional)</span></h5>
                  </div>
                  <div class="card-body">
                      @if($pendaftar->status_ganti_prodi == 'pending')
                          <!-- Status Pending -->
                          <div class="alert alert-warning">
                              <h6><i class="fas fa-clock me-2"></i>Pengajuan Sedang Diproses</h6>
                              <div class="row">
                                  <div class="col-md-8">
                                      <p class="mb-1"><strong>Dari:</strong> {{ $pendaftar->prodi->nama }} ({{ $pendaftar->kelas }})</p>
                                      <p class="mb-1"><strong>Ke:</strong> {{ $pendaftar->prodiBaru->nama ?? 'N/A' }} ({{ $pendaftar->kelas_baru }})</p>
                                      <p class="mb-1"><strong>Selisih Biaya:</strong> 
                                          @if($pendaftar->selisih_biaya_prodi > 0)
                                              <span class="text-danger">+ Rp {{ number_format($pendaftar->selisih_biaya_prodi, 0, ',', '.') }}</span>
                                          @elseif($pendaftar->selisih_biaya_prodi < 0)
                                              <span class="text-success">- Rp {{ number_format(abs($pendaftar->selisih_biaya_prodi), 0, ',', '.') }}</span>
                                          @else
                                              <span class="text-info">Tidak ada selisih</span>
                                          @endif
                                      </p>
                                  </div>
                                  <div class="col-md-4">
                                      <p class="mb-1"><strong>Alasan:</strong></p>
                                      <p class="mb-0 small">{{ $pendaftar->alasan_ganti_prodi }}</p>
                                  </div>
                              </div>
                          </div>
                          
                      @elseif($pendaftar->status_ganti_prodi == 'rejected')
                          <!-- Status Rejected - Bisa ajukan lagi -->
                          <div class="alert alert-danger mb-3">
                              <h6><i class="fas fa-times-circle me-2"></i>Pengajuan Ditolak</h6>
                              <p class="mb-0">Pengajuan pergantian prodi ditolak. Anda dapat mengajukan lagi dengan program studi yang berbeda.</p>
                          </div>
                          
                          <!-- Form Pergantian Prodi untuk yang Rejected -->
                          <form action="{{ route('user.formulir.ganti-prodi') }}" method="POST">
                              @csrf
                              <div class="row g-3 mb-3">
                                  <div class="col-md-4">
                                      <label class="form-label">Program Studi Saat Ini</label>
                                      <input type="text" class="form-control" value="{{ $pendaftar->prodi->nama }} ({{ $pendaftar->kelas }})" readonly>
                                  </div>
                                  <div class="col-md-4">
                                      <label for="prodi_baru_id" class="form-label required-field">Program Studi Baru</label>
                                      <select class="form-select" id="prodi_baru_id" name="prodi_baru_id" required>
                                          <option value="">Pilih Prodi Baru</option>
                                          @foreach($prodis as $prodi)
                                              @if($prodi->id != $pendaftar->prodi_id)
                                                  <option value="{{ $prodi->id }}" data-biaya="{{ $prodi->biaya }}">
                                                      {{ $prodi->nama }} - Rp {{ number_format($prodi->biaya, 0, ',', '.') }}
                                                  </option>
                                              @endif
                                          @endforeach
                                      </select>
                                  </div>
                                  <div class="col-md-4">
                                      <label for="kelas_baru" class="form-label required-field">Kelas Baru</label>
                                      <select class="form-select" id="kelas_baru" name="kelas_baru" required>
                                          <option value="">Pilih Kelas</option>
                                          <option value="Reguler Pagi">Reguler Pagi</option>
                                          <option value="Reguler Malam">Reguler Malam</option>
                                          <option value="Weekend">Weekend</option>
                                      </select>
                                  </div>
                              </div>
                              
                              <div id="selisih-biaya-info" class="alert alert-info" style="display: none;">
                                  <p class="mb-0"><strong>Selisih Biaya:</strong> <span id="selisih-amount"></span></p>
                              </div>
                              
                              <div class="mb-3">
                                  <label for="alasan_ganti_prodi" class="form-label required-field">Alasan Pergantian</label>
                                  <textarea class="form-control" id="alasan_ganti_prodi" name="alasan_ganti_prodi" rows="2" placeholder="Jelaskan alasan pergantian..." required></textarea>
                              </div>
                              
                              <button type="submit" class="btn btn-primary-custom">
                                  <i class="fas fa-paper-plane me-1"></i>Simpan Pergantian
                              </button>
                          </form>
                          
                      @else
                          <!-- Form Pergantian Prodi untuk yang belum pernah mengajukan -->
                          <div class="alert alert-info mb-3">
                              <i class="fas fa-info-circle me-2"></i>Anda dapat mengajukan pergantian program studi maksimal 1 kali.
                          </div>
                          
                          <form action="{{ route('user.formulir.ganti-prodi') }}" method="POST">
                              @csrf
                              <div class="row g-3 mb-3">
                                  <div class="col-md-4">
                                      <label class="form-label">Program Studi Saat Ini</label>
                                      <input type="text" class="form-control" value="{{ $pendaftar->prodi->nama }} ({{ $pendaftar->kelas }})" readonly>
                                  </div>
                                  <div class="col-md-4">
                                      <label for="prodi_baru_id" class="form-label required-field">Program Studi Baru</label>
                                      <select class="form-select" id="prodi_baru_id" name="prodi_baru_id" required>
                                          <option value="">Pilih Prodi Baru</option>
                                          @foreach($prodis as $prodi)
                                              @if($prodi->id != $pendaftar->prodi_id)
                                                  <option value="{{ $prodi->id }}" data-biaya="{{ $prodi->biaya }}">
                                                      {{ $prodi->nama }} - Rp {{ number_format($prodi->biaya, 0, ',', '.') }}
                                                  </option>
                                              @endif
                                          @endforeach
                                      </select>
                                  </div>
                                  <div class="col-md-4">
                                      <label for="kelas_baru" class="form-label required-field">Kelas Baru</label>
                                      <select class="form-select" id="kelas_baru" name="kelas_baru" required>
                                          <option value="">Pilih Kelas</option>
                                          <option value="Reguler Pagi">Reguler Pagi</option>
                                          <option value="Reguler Malam">Reguler Malam</option>
                                          <option value="Weekend">Weekend</option>
                                      </select>
                                  </div>
                              </div>
                              
                              <div id="selisih-biaya-info" class="alert alert-info" style="display: none;">
                                  <p class="mb-0"><strong>Selisih Biaya:</strong> <span id="selisih-amount"></span></p>
                              </div>
                              
                              <div class="mb-3">
                                  <label for="alasan_ganti_prodi" class="form-label required-field">Alasan Pergantian</label>
                                  <textarea class="form-control" id="alasan_ganti_prodi" name="alasan_ganti_prodi" rows="2" placeholder="Jelaskan alasan pergantian..." required></textarea>
                              </div>
                              
                              <button type="submit" class="btn btn-primary-custom">
                                  <i class="fas fa-paper-plane me-1"></i>Simpan Pergantian
                              </button>
                          </form>
                      @endif
                  </div>
              </div>
              @else
              <div class="alert alert-secondary mt-4">
                  <i class="fas fa-info-circle me-2"></i>Anda sudah menggunakan kesempatan pergantian program studi.
              </div>
              @endif
            @else
                <div class="alert alert-info mb-4">
                    <p><i class="fas fa-info-circle me-2"></i> Isilah form berikut dengan data yang benar dan lengkap. Field dengan tanda <span class="text-danger">*</span> wajib diisi.</p>
                </div>
                
                <form action="{{ route('user.formulir.store') }}" method="POST" enctype="multipart/form-data" id="formulirPendaftaran">
                    @csrf
                    
                    <!-- Step Indicator -->
                    <div class="step-indicator">
                        <div class="step active" data-step="1">
                            <div class="step-number">1</div>
                            <div class="step-title">Data Calon Mahasiswa</div>
                        </div>
                        <div class="step" data-step="2">
                            <div class="step-number">2</div>
                            <div class="step-title">Data Orang Tua/Wali</div>
                        </div>
                        <div class="step" data-step="3">
                            <div class="step-number">3</div>
                            <div class="step-title">Program Studi</div>
                        </div>
                        <div class="step" data-step="4">
                            <div class="step-number">4</div>
                            <div class="step-title">Data Asal Sekolah</div>
                        </div>
                        <div class="step" data-step="5">
                            <div class="step-number">5</div>
                            <div class="step-title">Berkas Pendaftaran</div>
                        </div>
                    </div>
                    
                    <!-- Form Sections -->
                    <div class="form-sections mt-4">
                        <!-- Section 1: Data Calon Mahasiswa -->
                        <div class="form-section active" id="section1">
                            <h5 class="border-bottom pb-2">Data Calon Mahasiswa</h5>
                            
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label for="nama_lengkap" class="form-label required-field">Nama Lengkap (Sesuai Ijazah)</label>
                                    <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required>
                                    @error('nama_lengkap')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-3">
                                    <label for="tempat_lahir" class="form-label required-field">Tempat Lahir</label>
                                    <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir') }}" required>
                                    @error('tempat_lahir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-3">
                                    <label for="tanggal_lahir" class="form-label required-field">Tanggal Lahir</label>
                                    <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required>
                                    @error('tanggal_lahir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row g-3 mb-3">
                                <div class="col-md-4">
                                    <label class="form-label required-field">Jenis Kelamin</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="jenis_kelamin" id="jk_laki" value="Laki-Laki" {{ old('jenis_kelamin') == 'Laki-Laki' ? 'checked' : '' }} required>
                                            <label class="form-check-label" for="jk_laki">Laki-Laki</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="jenis_kelamin" id="jk_perempuan" value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="jk_perempuan">Perempuan</label>
                                        </div>
                                        @error('jenis_kelamin')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <label for="nik" class="form-label required-field">NIK (Nomor Induk Kependudukan)</label>
                                    <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik" name="nik" value="{{ old('nik') }}" required>
                                    @error('nik')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-4">
                                    <label for="agama" class="form-label required-field">Agama</label>
                                    <select class="form-select @error('agama') is-invalid @enderror" id="agama" name="agama" required>
                                        <option value="">Pilih Agama</option>
                                        <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                        <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                        <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                        <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                        <option value="Budha" {{ old('agama') == 'Budha' ? 'selected' : '' }}>Budha</option>
                                        <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                                    </select>
                                    @error('agama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row g-3 mb-3">
                                <div class="col-md-4">
                                    <label for="nisn" class="form-label required-field">NISN (Nomor Induk Siswa Nasional)</label>
                                    <input type="text" class="form-control @error('nisn') is-invalid @enderror" id="nisn" name="nisn" value="{{ old('nisn') }}" required>
                                    @error('nisn')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-8">
                                    <label class="form-label required-field">Jenis Pendaftaran</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="jenis_pendaftaran" id="pendaftaran_baru" value="Peserta didik baru" {{ old('jenis_pendaftaran') == 'Peserta didik baru' ? 'checked' : '' }} required>
                                            <label class="form-check-label" for="pendaftaran_baru">Peserta didik baru</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="jenis_pendaftaran" id="pendaftaran_pindahan" value="Pindahan" {{ old('jenis_pendaftaran') == 'Pindahan' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="pendaftaran_pindahan">Pindahan</label>
                                        </div>
                                        @error('jenis_pendaftaran')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="alamat" class="form-label required-field">Alamat Lengkap</label>
                                <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3" required>{{ old('alamat') }}</textarea>
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label for="jenis_tinggal" class="form-label required-field">Jenis Tinggal</label>
                                    <select class="form-select @error('jenis_tinggal') is-invalid @enderror" id="jenis_tinggal" name="jenis_tinggal" required>
                                        <option value="">Pilih Jenis Tinggal</option>
                                        <option value="Bersama orang tua" {{ old('jenis_tinggal') == 'Bersama orang tua' ? 'selected' : '' }}>Bersama orang tua</option>
                                        <option value="Wali" {{ old('jenis_tinggal') == 'Wali' ? 'selected' : '' }}>Wali</option>
                                        <option value="Kost" {{ old('jenis_tinggal') == 'Kost' ? 'selected' : '' }}>Kost</option>
                                        <option value="Asrama" {{ old('jenis_tinggal') == 'Asrama' ? 'selected' : '' }}>Asrama</option>
                                        <option value="Lainnya" {{ old('jenis_tinggal') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                    </select>
                                    @error('jenis_tinggal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="alat_transportasi" class="form-label required-field">Alat Transportasi</label>
                                    <select class="form-select @error('alat_transportasi') is-invalid @enderror" id="alat_transportasi" name="alat_transportasi" required>
                                        <option value="">Pilih Alat Transportasi</option>
                                        <option value="Jalan kaki" {{ old('alat_transportasi') == 'Jalan kaki' ? 'selected' : '' }}>Jalan kaki</option>
                                        <option value="Sepeda motor" {{ old('alat_transportasi') == 'Sepeda motor' ? 'selected' : '' }}>Sepeda motor</option>
                                        <option value="Mobil pribadi" {{ old('alat_transportasi') == 'Mobil pribadi' ? 'selected' : '' }}>Mobil pribadi</option>
                                        <option value="Angkutan umum" {{ old('alat_transportasi') == 'Angkutan umum' ? 'selected' : '' }}>Angkutan umum</option>
                                        <option value="Sepeda" {{ old('alat_transportasi') == 'Sepeda' ? 'selected' : '' }}>Sepeda</option>
                                        <option value="Lainnya" {{ old('alat_transportasi') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                    </select>
                                    @error('alat_transportasi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label for="no_hp" class="form-label required-field">Nomor WhatsApp Aktif</label>
                                    <input type="text" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp" name="no_hp" value="{{ old('no_hp') }}" required>
                                    @error('no_hp')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="email" class="form-label required-field">Email Aktif</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', Auth::user()->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row g-3 mb-3">
                                <div class="col-md-4">
                                    <label class="form-label required-field">Terima KPS (Kartu Perlindungan Sosial)</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="kps" id="kps_ya" value="Ya" {{ old('kps') == 'Ya' ? 'checked' : '' }} required>
                                            <label class="form-check-label" for="kps_ya">Ya</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="kps" id="kps_tidak" value="Tidak" {{ old('kps') == 'Tidak' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="kps_tidak">Tidak</label>
                                        </div>
                                        @error('kps')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-8" id="no_kps_section" style="display: none;">
                                    <label for="no_kps" class="form-label required-field">No KPS</label>
                                    <input type="text" class="form-control @error('no_kps') is-invalid @enderror" id="no_kps" name="no_kps" value="{{ old('no_kps') }}">
                                    @error('no_kps')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Isi jika memiliki Kartu Perlindungan Sosial</div>
                                </div>
                            </div>
                            
                            <div class="row g-3 mb-3">
                                <div class="col-md-4">
                                    <label class="form-label required-field">Sudah Bekerja</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="bekerja" id="bekerja_ya" value="Ya" {{ old('bekerja') == 'Ya' ? 'checked' : '' }} required>
                                            <label class="form-check-label" for="bekerja_ya">Ya</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="bekerja" id="bekerja_tidak" value="Tidak" {{ old('bekerja') == 'Tidak' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="bekerja_tidak">Tidak</label>
                                        </div>
                                        @error('bekerja')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-8" id="bekerja_section" style="display: none;">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="tempat_kerja" class="form-label required-field">Tempat Kerja</label>
                                            <input type="text" class="form-control @error('tempat_kerja') is-invalid @enderror" id="tempat_kerja" name="tempat_kerja" value="{{ old('tempat_kerja') }}">
                                            @error('tempat_kerja')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <label for="penghasilan" class="form-label required-field">Penghasilan</label>
                                            <select class="form-select @error('penghasilan') is-invalid @enderror" id="penghasilan" name="penghasilan">
                                                <option value="">Pilih Penghasilan</option>
                                                <option value="Kurang dari Rp.500.000" {{ old('penghasilan') == 'Kurang dari Rp.500.000' ? 'selected' : '' }}>Kurang dari Rp.500.000</option>
                                                <option value="Rp.500.000 - Rp.999.999" {{ old('penghasilan') == 'Rp.500.000 - Rp.999.999' ? 'selected' : '' }}>Rp.500.000 - Rp.999.999</option>
                                                <option value="Rp.1.000.000 - Rp.1.999.999" {{ old('penghasilan') == 'Rp.1.000.000 - Rp.1.999.999' ? 'selected' : '' }}>Rp.1.000.000 - Rp.1.999.999</option>
                                                <option value="Rp.2.000.000 - Rp.4.999.999" {{ old('penghasilan') == 'Rp.2.000.000 - Rp.4.999.999' ? 'selected' : '' }}>Rp.2.000.000 - Rp.4.999.999</option>
                                                <option value="Rp.5.000.000 - Rp.20.000.000" {{ old('penghasilan') == 'Rp.5.000.000 - Rp.20.000.000' ? 'selected' : '' }}>Rp.5.000.000 - Rp.20.000.000</option>
                                                <option value="Lebih dari Rp.20.000.000" {{ old('penghasilan') == 'Lebih dari Rp.20.000.000' ? 'selected' : '' }}>Lebih dari Rp.20.000.000</option>
                                            </select>
                                            @error('penghasilan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Section 2: Data Orang Tua/Wali -->
                        <div class="form-section" id="section2">
                            <h5 class="border-bottom pb-2">Data Orang Tua/Wali</h5>
                            
                            <h6 class="mt-4 mb-3">Data Ayah</h6>
                            <div class="row g-3 mb-3">
                                <div class="col-md-4">
                                    <label for="nik_ayah" class="form-label required-field">NIK Ayah</label>
                                    <input type="text" class="form-control @error('nik_ayah') is-invalid @enderror" id="nik_ayah" name="nik_ayah" value="{{ old('nik_ayah') }}" required>
                                    @error('nik_ayah')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-4">
                                    <label for="nama_ayah" class="form-label required-field">Nama Ayah</label>
                                    <input type="text" class="form-control @error('nama_ayah') is-invalid @enderror" id="nama_ayah" name="nama_ayah" value="{{ old('nama_ayah') }}" required>
                                    @error('nama_ayah')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-4">
                                    <label for="tanggal_lahir_ayah" class="form-label required-field">Tanggal Lahir Ayah</label>
                                    <input type="date" class="form-control @error('tanggal_lahir_ayah') is-invalid @enderror" id="tanggal_lahir_ayah" name="tanggal_lahir_ayah" value="{{ old('tanggal_lahir_ayah') }}" required>
                                    @error('tanggal_lahir_ayah')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row g-3 mb-4">
                                <div class="col-md-4">
                                    <label for="pendidikan_ayah" class="form-label required-field">Pendidikan Terakhir Ayah</label>
                                    <select class="form-select @error('pendidikan_ayah') is-invalid @enderror" id="pendidikan_ayah" name="pendidikan_ayah" required>
                                        <option value="">Pilih Pendidikan</option>
                                        <option value="SD/Sederajat" {{ old('pendidikan_ayah') == 'SD/Sederajat' ? 'selected' : '' }}>SD/Sederajat</option>
                                        <option value="SMP/Sederajat" {{ old('pendidikan_ayah') == 'SMP/Sederajat' ? 'selected' : '' }}>SMP/Sederajat</option>
                                        <option value="SMA/SMK/Sederajat" {{ old('pendidikan_ayah') == 'SMA/SMK/Sederajat' ? 'selected' : '' }}>SMA/SMK/Sederajat</option>
                                        <option value="D1" {{ old('pendidikan_ayah') == 'D1' ? 'selected' : '' }}>D1</option>
                                        <option value="D2" {{ old('pendidikan_ayah') == 'D2' ? 'selected' : '' }}>D2</option>
                                        <option value="D3" {{ old('pendidikan_ayah') == 'D3' ? 'selected' : '' }}>D3</option>
                                        <option value="D4/S1" {{ old('pendidikan_ayah') == 'D4/S1' ? 'selected' : '' }}>D4/S1</option>
                                        <option value="S2" {{ old('pendidikan_ayah') == 'S2' ? 'selected' : '' }}>S2</option>
                                        <option value="S3" {{ old('pendidikan_ayah') == 'S3' ? 'selected' : '' }}>S3</option>
                                        <option value="Tidak Sekolah" {{ old('pendidikan_ayah') == 'Tidak Sekolah' ? 'selected' : '' }}>Tidak Sekolah</option>
                                    </select>
                                    @error('pendidikan_ayah')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-4">
                                    <label for="pekerjaan_ayah" class="form-label required-field">Pekerjaan Ayah</label>
                                    <input type="text" class="form-control @error('pekerjaan_ayah') is-invalid @enderror" id="pekerjaan_ayah" name="pekerjaan_ayah" value="{{ old('pekerjaan_ayah') }}" required>
                                    @error('pekerjaan_ayah')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-4">
                                    <label for="penghasilan_ayah" class="form-label required-field">Penghasilan Ayah</label>
                                    <select class="form-select @error('penghasilan_ayah') is-invalid @enderror" id="penghasilan_ayah" name="penghasilan_ayah" required>
                                        <option value="">Pilih Penghasilan</option>
                                        <option value="Kurang dari Rp.500.000" {{ old('penghasilan_ayah') == 'Kurang dari Rp.500.000' ? 'selected' : '' }}>Kurang dari Rp.500.000</option>
                                        <option value="Rp.500.000 - Rp.999.999" {{ old('penghasilan_ayah') == 'Rp.500.000 - Rp.999.999' ? 'selected' : '' }}>Rp.500.000 - Rp.999.999</option>
                                        <option value="Rp.1.000.000 - Rp.1.999.999" {{ old('penghasilan_ayah') == 'Rp.1.000.000 - Rp.1.999.999' ? 'selected' : '' }}>Rp.1.000.000 - Rp.1.999.999</option>
                                        <option value="Rp.2.000.000 - Rp.4.999.999" {{ old('penghasilan_ayah') == 'Rp.2.000.000 - Rp.4.999.999' ? 'selected' : '' }}>Rp.2.000.000 - Rp.4.999.999</option>
                                        <option value="Rp.5.000.000 - Rp.20.000.000" {{ old('penghasilan_ayah') == 'Rp.5.000.000 - Rp.20.000.000' ? 'selected' : '' }}>Rp.5.000.000 - Rp.20.000.000</option>
                                        <option value="Lebih dari Rp.20.000.000" {{ old('penghasilan_ayah') == 'Lebih dari Rp.20.000.000' ? 'selected' : '' }}>Lebih dari Rp.20.000.000</option>
                                    </select>
                                    @error('penghasilan_ayah')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <h6 class="mt-4 mb-3">Data Ibu</h6>
                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <label for="nik_ibu" class="form-label required-field">NIK Ibu</label>
                                <input type="text" class="form-control @error('nik_ibu') is-invalid @enderror" id="nik_ibu" name="nik_ibu" value="{{ old('nik_ibu') }}" required>
                                @error('nik_ibu')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-4">
                                <label for="nama_ibu" class="form-label required-field">Nama Ibu</label>
                                <input type="text" class="form-control @error('nama_ibu') is-invalid @enderror" id="nama_ibu" name="nama_ibu" value="{{ old('nama_ibu') }}" required>
                                @error('nama_ibu')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-4">
                                <label for="tanggal_lahir_ibu" class="form-label required-field">Tanggal Lahir Ibu</label>
                                <input type="date" class="form-control @error('tanggal_lahir_ibu') is-invalid @enderror" id="tanggal_lahir_ibu" name="tanggal_lahir_ibu" value="{{ old('tanggal_lahir_ibu') }}" required>
                                @error('tanggal_lahir_ibu')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="pekerjaan_ibu" class="form-label required-field">Pekerjaan Ibu</label>
                                <input type="text" class="form-control @error('pekerjaan_ibu') is-invalid @enderror" id="pekerjaan_ibu" name="pekerjaan_ibu" value="{{ old('pekerjaan_ibu') }}" required>
                                @error('pekerjaan_ibu')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="penghasilan_ibu" class="form-label required-field">Penghasilan Ibu</label>
                                <select class="form-select @error('penghasilan_ibu') is-invalid @enderror" id="penghasilan_ibu" name="penghasilan_ibu" required>
                                    <option value="">Pilih Penghasilan</option>
                                    <option value="Kurang dari Rp.500.000" {{ old('penghasilan_ibu') == 'Kurang dari Rp.500.000' ? 'selected' : '' }}>Kurang dari Rp.500.000</option>
                                    <option value="Rp.500.000 - Rp.999.999" {{ old('penghasilan_ibu') == 'Rp.500.000 - Rp.999.999' ? 'selected' : '' }}>Rp.500.000 - Rp.999.999</option>
                                    <option value="Rp.1.000.000 - Rp.1.999.999" {{ old('penghasilan_ibu') == 'Rp.1.000.000 - Rp.1.999.999' ? 'selected' : '' }}>Rp.1.000.000 - Rp.1.999.999</option>
                                    <option value="Rp.2.000.000 - Rp.4.999.999" {{ old('penghasilan_ibu') == 'Rp.2.000.000 - Rp.4.999.999' ? 'selected' : '' }}>Rp.2.000.000 - Rp.4.999.999</option>
                                    <option value="Rp.5.000.000 - Rp.20.000.000" {{ old('penghasilan_ibu') == 'Rp.5.000.000 - Rp.20.000.000' ? 'selected' : '' }}>Rp.5.000.000 - Rp.20.000.000</option>
                                    <option value="Lebih dari Rp.20.000.000" {{ old('penghasilan_ibu') == 'Lebih dari Rp.20.000.000' ? 'selected' : '' }}>Lebih dari Rp.20.000.000</option>
                                </select>
                                @error('penghasilan_ibu')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <h6 class="mt-4 mb-3">Data Wali <span class="text-muted small">(Opsional)</span></h6>
                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <label for="nik_wali" class="form-label">NIK Wali</label>
                                <input type="text" class="form-control @error('nik_wali') is-invalid @enderror" id="nik_wali" name="nik_wali" value="{{ old('nik_wali') }}">
                                @error('nik_wali')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-4">
                                <label for="nama_wali" class="form-label">Nama Wali</label>
                                <input type="text" class="form-control @error('nama_wali') is-invalid @enderror" id="nama_wali" name="nama_wali" value="{{ old('nama_wali') }}">
                                @error('nama_wali')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-4">
                                <label for="tanggal_lahir_wali" class="form-label">Tanggal Lahir Wali</label>
                                <input type="date" class="form-control @error('tanggal_lahir_wali') is-invalid @enderror" id="tanggal_lahir_wali" name="tanggal_lahir_wali" value="{{ old('tanggal_lahir_wali') }}">
                                @error('tanggal_lahir_wali')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="pekerjaan_wali" class="form-label">Pekerjaan Wali</label>
                                <input type="text" class="form-control @error('pekerjaan_wali') is-invalid @enderror" id="pekerjaan_wali" name="pekerjaan_wali" value="{{ old('pekerjaan_wali') }}">
                                @error('pekerjaan_wali')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="penghasilan_wali" class="form-label">Penghasilan Wali</label>
                                <select class="form-select @error('penghasilan_wali') is-invalid @enderror" id="penghasilan_wali" name="penghasilan_wali">
                                    <option value="">Pilih Penghasilan</option>
                                    <option value="Kurang dari Rp.500.000" {{ old('penghasilan_wali') == 'Kurang dari Rp.500.000' ? 'selected' : '' }}>Kurang dari Rp.500.000</option>
                                    <option value="Rp.500.000 - Rp.999.999" {{ old('penghasilan_wali') == 'Rp.500.000 - Rp.999.999' ? 'selected' : '' }}>Rp.500.000 - Rp.999.999</option>
                                    <option value="Rp.1.000.000 - Rp.1.999.999" {{ old('penghasilan_wali') == 'Rp.1.000.000 - Rp.1.999.999' ? 'selected' : '' }}>Rp.1.000.000 - Rp.1.999.999</option>
                                    <option value="Rp.2.000.000 - Rp.4.999.999" {{ old('penghasilan_wali') == 'Rp.2.000.000 - Rp.4.999.999' ? 'selected' : '' }}>Rp.2.000.000 - Rp.4.999.999</option>
                                    <option value="Rp.5.000.000 - Rp.20.000.000" {{ old('penghasilan_wali') == 'Rp.5.000.000 - Rp.20.000.000' ? 'selected' : '' }}>Rp.5.000.000 - Rp.20.000.000</option>
                                    <option value="Lebih dari Rp.20.000.000" {{ old('penghasilan_wali') == 'Lebih dari Rp.20.000.000' ? 'selected' : '' }}>Lebih dari Rp.20.000.000</option>
                                </select>
                                @error('penghasilan_wali')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="no_hp_ortu" class="form-label required-field">Nomor HP Orang Tua/Wali</label>
                            <input type="text" class="form-control @error('no_hp_ortu') is-invalid @enderror" id="no_hp_ortu" name="no_hp_ortu" value="{{ old('no_hp_ortu') }}" required>
                            @error('no_hp_ortu')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Section 3: Program Studi -->
                    <div class="form-section" id="section3">
                        <h5 class="border-bottom pb-2">Program Studi Pilihan</h5>
                        
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="prodi_id" class="form-label required-field">Program Studi</label>
                                <select class="form-select @error('prodi_id') is-invalid @enderror" id="prodi_id" name="prodi_id" required>
                                    <option value="">Pilih Program Studi</option>
                                    @foreach($prodis as $prodi)
                                        <option value="{{ $prodi->id }}" data-kuota="{{ $prodi->kuota_tersisa }}" {{ old('prodi_id') == $prodi->id ? 'selected' : '' }}>
                                            {{ $prodi->nama }} ({{ $prodi->jenjang }}) ({{ $prodi->akreditasi }}) - Kuota tersisa: {{ $prodi->kuota_tersisa }}
                                        </option>
                                    @endforeach
                                </select>
                    
                                <script>
                                    (function () {
                                      var prodiSelect = document.getElementById('prodi_id');
                                      if (!prodiSelect) return;
                                    
                                      // Ambil form terdekat yang membungkus select ini
                                      var form = prodiSelect.closest('form');
                                      if (!form) return;
                                    
                                      form.addEventListener('submit', function (e) {
                                        var opt = prodiSelect.options[prodiSelect.selectedIndex];
                                        var sisa = parseInt((opt && opt.getAttribute('data-kuota')) || '0', 10);
                                    
                                        if (isNaN(sisa)) sisa = 0;
                                    
                                        if (sisa <= 0) {
                                          e.preventDefault(); // blok submit
                                          // Tampilkan pesan sederhana
                                          alert('⚠ Kuota untuk prodi yang kamu pilih sudah penuh. Silakan pilih prodi lain.');
                                          // Fokuskan ke field prodi
                                          prodiSelect.focus();
                                        }
                                      });
                                    
                                      // Opsional: bersihin pesan validasi ketika ganti pilihan
                                      prodiSelect.addEventListener('change', function () {
                                        // tidak perlu apa-apa di sini, tapi kalau mau kasih peringatan tambahan bisa
                                      });
                                    })();
                                    </script>                                    
                    
                                @error('prodi_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="kelas" class="form-label required-field">Pilihan Kelas</label>
                                <select class="form-select @error('kelas') is-invalid @enderror" id="kelas" name="kelas" required>
                                    <option value="">Pilih Kelas</option>
                                    <option value="Reguler Pagi" {{ old('kelas') == 'Reguler Pagi' ? 'selected' : '' }}>Reguler Pagi</option>
                                    <option value="Reguler Malam" {{ old('kelas') == 'Reguler Malam' ? 'selected' : '' }}>Reguler Malam</option>
                                    <option value="Weekend" {{ old('kelas') == 'Weekend' ? 'selected' : '' }}>Weekend</option>
                                </select>
                                @error('kelas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="text-danger small mt-2" id="kelas-warning" style="display: none;"></div>
                            </div>
                        </div>
                        
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="ukuran_almamater" class="form-label required-field">Ukuran Jas Almamater</label>
                                <select class="form-select @error('ukuran_almamater') is-invalid @enderror" id="ukuran_almamater" name="ukuran_almamater" required>
                                    <option value="">Pilih Ukuran</option>
                                    <option value="S" {{ old('ukuran_almamater') == 'S' ? 'selected' : '' }}>S</option>
                                    <option value="M" {{ old('ukuran_almamater') == 'M' ? 'selected' : '' }}>M</option>
                                    <option value="L" {{ old('ukuran_almamater') == 'L' ? 'selected' : '' }}>L</option>
                                    <option value="XL" {{ old('ukuran_almamater') == 'XL' ? 'selected' : '' }}>XL</option>
                                    <option value="XXL" {{ old('ukuran_almamater') == 'XXL' ? 'selected' : '' }}>XXL</option>
                                    <option value="XXXL" {{ old('ukuran_almamater') == 'XXXL' ? 'selected' : '' }}>XXXL</option>
                                    <option value="4L" {{ old('ukuran_almamater') == '4L' ? 'selected' : '' }}>4L</option>
                                </select>
                                @error('ukuran_almamater')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="ukuran_kaos" class="form-label required-field">Ukuran Kaos PKKMB</label>
                                <select class="form-select @error('ukuran_kaos') is-invalid @enderror" id="ukuran_kaos" name="ukuran_kaos" required>
                                    <option value="">Pilih Ukuran</option>
                                    <option value="S" {{ old('ukuran_kaos') == 'S' ? 'selected' : '' }}>S</option>
                                    <option value="M" {{ old('ukuran_kaos') == 'M' ? 'selected' : '' }}>M</option>
                                    <option value="L" {{ old('ukuran_kaos') == 'L' ? 'selected' : '' }}>L</option>
                                    <option value="XL" {{ old('ukuran_kaos') == 'XL' ? 'selected' : '' }}>XL</option>
                                    <option value="XXL" {{ old('ukuran_kaos') == 'XXL' ? 'selected' : '' }}>XXL</option>
                                    <option value="XXXL" {{ old('ukuran_kaos') == 'XXXL' ? 'selected' : '' }}>XXXL</option>
                                    <option value="4L" {{ old('ukuran_kaos') == '4L' ? 'selected' : '' }}>4L</option>
                                </select>
                                @error('ukuran_kaos')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="alert alert-info mt-4">
                            <h6 class="mb-2"><i class="fas fa-info-circle me-2"></i> Informasi Kelas:</h6>
                            <ul class="mb-0">
                                <li><strong>Kelas Reguler Pagi:</strong> Teknik Informatika, DKV, Ilmu Komunikasi, Psikologi, Manajemen, Akuntansi, Bisnis Digital, HKI, PAI, PGMI, PIAUD, HES.</li>
                                <li><strong>Kelas Reguler Malam:</strong> Teknik Sipil, Teknik Industri, Teknik Informatika, DKV, Ilmu Komunikasi, Ilmu Pemerintahan, Psikologi, Ilmu Hukum, Manajemen, Akuntansi, Bisnis Digital, PAI, PGMI, PIAUD, HES, HKI.</li>
                                <li><strong>Kelas Weekend:</strong> Teknik Sipil, Ilmu Komunikasi, Ilmu Pemerintahan, Ilmu Hukum, Bisnis Digital, PAI, PGMI, PIAUD, HES, HKI.</li>
                            </ul>
                        </div>
                    </div>
                    
                    <!-- Section 4: Data Asal Sekolah -->
                    <div class="form-section" id="section4">
                        <h5 class="border-bottom pb-2">Data Asal Sekolah</h5>
                        
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="asal_sekolah" class="form-label required-field">Asal Sekolah</label>
                                <input type="text" class="form-control @error('asal_sekolah') is-invalid @enderror" id="asal_sekolah" name="asal_sekolah" value="{{ old('asal_sekolah') }}" required>
                                @error('asal_sekolah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="tahun_lulus" class="form-label required-field">Tahun Lulus</label>
                                <input type="number" class="form-control @error('tahun_lulus') is-invalid @enderror" id="tahun_lulus" name="tahun_lulus" value="{{ old('tahun_lulus') }}" min="1990" max="2025" required>
                                @error('tahun_lulus')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div id="pindahan_section" style="display: none;">
                            <div class="row g-3 mb-3">
                                <div class="col-md-4">
                                    <label for="asal_perguruan_tinggi" class="form-label">Asal Perguruan Tinggi</label>
                                    <input type="text" class="form-control @error('asal_perguruan_tinggi') is-invalid @enderror" id="asal_perguruan_tinggi" name="asal_perguruan_tinggi" value="{{ old('asal_perguruan_tinggi') }}">
                                    @error('asal_perguruan_tinggi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Isi jika mahasiswa pindahan</div>
                                </div>
                                
                                <div class="col-md-4">
                                    <label for="asal_prodi" class="form-label">Asal Program Studi</label>
                                    <input type="text" class="form-control @error('asal_prodi') is-invalid @enderror" id="asal_prodi" name="asal_prodi" value="{{ old('asal_prodi') }}">
                                    @error('asal_prodi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Isi jika mahasiswa pindahan</div>
                                </div>
                                
                                <div class="col-md-4">
                                    <label for="semester_terakhir" class="form-label">Semester Terakhir</label>
                                    <input type="number" class="form-control @error('semester_terakhir') is-invalid @enderror" id="semester_terakhir" name="semester_terakhir" value="{{ old('semester_terakhir') }}" min="1" max="14">
                                    @error('semester_terakhir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Isi jika mahasiswa pindahan</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Section 5: Berkas Pendaftaran -->
                    <div class="form-section" id="section5">
                        <h5 class="border-bottom pb-2">Berkas Pendaftaran</h5>
                        
                        <div class="alert alert-info mb-4">
                            <h6 class="mb-2"><i class="fas fa-info-circle me-2"></i> Informasi Berkas Pendaftaran:</h6>
                            <p>Berikut berkas pendaftaran yang harus di-upload:</p>
                            <ol>
                                <li>Scan Ijazah</li>
                                <li>Scan Transkrip Nilai</li>
                                <li>Scan KTP</li>
                                <li>Scan KK</li>
                                <li>Pas Foto Terbaru (Pakaian Bebas Sopan, Background Merah)</li>
                            </ol>
                            <p class="mb-0"><strong>CATATAN:</strong> Berkas Pendaftaran harus jelas dan dijadikan satu file dengan format PDF.</p>
                        </div>
                        
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="berkas_pendaftaran" class="form-label required-field">Upload Berkas Pendaftaran (PDF)</label>
                                <input type="file" class="form-control @error('berkas_pendaftaran') is-invalid @enderror" id="berkas_pendaftaran" name="berkas_pendaftaran" accept=".pdf" required>
                                @error('berkas_pendaftaran')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Ukuran maksimal 5MB</div>
                            </div>
                            
                            <div class="col-md-6">
                                <label for="pas_foto" class="form-label required-field">Upload Pas Foto (JPG/PNG)</label>
                                <input type="file" class="form-control @error('pas_foto') is-invalid @enderror" id="pas_foto" name="pas_foto" accept=".jpg,.jpeg,.png" required>
                                @error('pas_foto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Ukuran maksimal 2MB</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Form Navigation -->
                    <div class="form-navigation d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-secondary" id="prevBtn" style="display: none;">
                            <i class="fas fa-arrow-left me-1"></i> Sebelumnya
                        </button>
                        <button type="button" class="btn btn-primary-custom" id="nextBtn">
                            Selanjutnya <i class="fas fa-arrow-right ms-1"></i>
                        </button>
                        <button type="submit" class="btn btn-accent-custom" id="submitBtn" style="display: none;">
                            <i class="fas fa-save me-1"></i> Simpan Formulir
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Variables
        let currentSection = 1;
        const totalSections = 5;
        const formSections = document.querySelectorAll('.form-section');
        const steps = document.querySelectorAll('.step');
        const nextBtn = document.getElementById('nextBtn');
        const prevBtn = document.getElementById('prevBtn');
        const submitBtn = document.getElementById('submitBtn');
        
        // KPS checkbox handler
        const kpsYa = document.getElementById('kps_ya');
        const kpsTidak = document.getElementById('kps_tidak');
        const noKpsSection = document.getElementById('no_kps_section');
        
        if (kpsYa && kpsTidak && noKpsSection) {
            kpsYa.addEventListener('change', function() {
                noKpsSection.style.display = this.checked ? 'block' : 'none';
            });
            
            kpsTidak.addEventListener('change', function() {
                noKpsSection.style.display = 'none';
            });
            
            // Initial state
            if (kpsYa.checked) {
                noKpsSection.style.display = 'block';
            }
        }
        
        // Bekerja checkbox handler
        const bekerjaYa = document.getElementById('bekerja_ya');
        const bekerjaTidak = document.getElementById('bekerja_tidak');
        const bekerjaSection = document.getElementById('bekerja_section');
        
        if (bekerjaYa && bekerjaTidak && bekerjaSection) {
            bekerjaYa.addEventListener('change', function() {
                bekerjaSection.style.display = this.checked ? 'block' : 'none';
            });
            
            bekerjaTidak.addEventListener('change', function() {
                bekerjaSection.style.display = 'none';
            });
            
            // Initial state
            if (bekerjaYa.checked) {
                bekerjaSection.style.display = 'block';
            }
        }
        
         // Jenis Pendaftaran handler
         const pendaftaranBaru = document.getElementById('pendaftaran_baru');
        const pendaftaranPindahan = document.getElementById('pendaftaran_pindahan');
        const pindahanSection = document.getElementById('pindahan_section');
        
        if (pendaftaranBaru && pendaftaranPindahan && pindahanSection) {
            pendaftaranBaru.addEventListener('change', function() {
                pindahanSection.style.display = 'none';
            });
            
            pendaftaranPindahan.addEventListener('change', function() {
                pindahanSection.style.display = 'block';
            });
            
            // Initial state
            if (pendaftaranPindahan.checked) {
                pindahanSection.style.display = 'block';
            }
        }
        
        // Handle prodi and kelas selection
        const prodiSelect = document.getElementById('prodi_id');
        const kelasSelect = document.getElementById('kelas');
        const kelasWarning = document.getElementById('kelas-warning');
        
        if (prodiSelect && kelasSelect && kelasWarning) {
            // Program studi availability for each kelas
            const kelasMappings = {
                'Reguler Pagi': ['Teknik Informatika', 'DKV', 'Ilmu Komunikasi', 'Psikologi', 'Manajemen', 'Akuntansi', 'Bisnis Digital', 'HKI', 'PAI', 'PGMI', 'PIAUD', 'HES'],
                'Reguler Malam': ['Teknik Sipil', 'Teknik Industri', 'Teknik Informatika', 'DKV', 'Ilmu Komunikasi', 'Ilmu Pemerintahan', 'Psikologi', 'Ilmu Hukum', 'Manajemen', 'Akuntansi', 'Bisnis Digital', 'PAI', 'PGMI', 'PIAUD', 'HES', 'HKI'],
                'Weekend': ['Teknik Sipil', 'Ilmu Komunikasi', 'Ilmu Pemerintahan', 'Ilmu Hukum', 'Bisnis Digital', 'PAI', 'PGMI', 'PIAUD', 'HES', 'HKI']
            };
            
            const validateKelas = function() {
                const prodiOption = prodiSelect.options[prodiSelect.selectedIndex];
                const prodiName = prodiOption ? prodiOption.text.split('(')[0].trim() : '';
                const kelas = kelasSelect.value;
                
                if (prodiName && kelas && !kelasMappings[kelas].includes(prodiName)) {
                    kelasWarning.textContent = 'Program studi ' + prodiName + ' tidak tersedia di kelas ' + kelas;
                    kelasWarning.style.display = 'block';
                } else {
                    kelasWarning.style.display = 'none';
                }
            };
            
            prodiSelect.addEventListener('change', validateKelas);
            kelasSelect.addEventListener('change', validateKelas);
            
            // Validate on page load
            if (prodiSelect.value && kelasSelect.value) {
                validateKelas();
            }
        }
        
        // Handle selisih biaya calculation
        const prodiBaru = document.getElementById('prodi_baru_id');
        const selisihInfo = document.getElementById('selisih-biaya-info');
        const selisihAmount = document.getElementById('selisih-amount');
        
        if (prodiBaru && selisihInfo && selisihAmount) {
            const biayaLama = {{ $pendaftar ? $pendaftar->prodi->biaya : 0 }};
            
            prodiBaru.addEventListener('change', function() {
                if (this.value) {
                    const selectedOption = this.options[this.selectedIndex];
                    const biayaBaru = parseFloat(selectedOption.dataset.biaya);
                    const selisih = biayaBaru - biayaLama;
                    
                    if (selisih > 0) {
                        selisihAmount.innerHTML = '<span class="text-danger">+ Rp ' + new Intl.NumberFormat('id-ID').format(selisih) + ' (Perlu bayar tambahan)</span>';
                        selisihInfo.className = 'alert alert-warning';
                    } else if (selisih < 0) {
                        selisihAmount.innerHTML = '<span class="text-success">- Rp ' + new Intl.NumberFormat('id-ID').format(Math.abs(selisih)) + ' (Tidak ada pengembalian)</span>';
                        selisihInfo.className = 'alert alert-info';
                    } else {
                        selisihAmount.innerHTML = '<span class="text-info">Tidak ada selisih biaya</span>';
                        selisihInfo.className = 'alert alert-info';
                    }
                    
                    selisihInfo.style.display = 'block';
                } else {
                    selisihInfo.style.display = 'none';
                }
            });
        }
        
        // Navigation functions
        function showSection(n) {
            // Hide all sections
            formSections.forEach(section => {
                section.classList.remove('active');
            });
            
            // Show the current section
            formSections[n-1].classList.add('active');
            
            // Update steps
            steps.forEach((step, index) => {
                if (index + 1 < n) {
                    step.classList.add('completed');
                    step.classList.remove('active');
                } else if (index + 1 === n) {
                    step.classList.add('active');
                    step.classList.remove('completed');
                } else {
                    step.classList.remove('active', 'completed');
                }
            });
            
            // Update buttons
            if (n === 1) {
                prevBtn.style.display = 'none';
            } else {
                prevBtn.style.display = 'block';
            }
            
            if (n === totalSections) {
                nextBtn.style.display = 'none';
                submitBtn.style.display = 'block';
            } else {
                nextBtn.style.display = 'block';
                submitBtn.style.display = 'none';
            }
        }
        
        function validateSection(n) {
            const section = formSections[n-1];
            const inputs = section.querySelectorAll('input[required], select[required], textarea[required]');
            let valid = true;
            
            inputs.forEach(input => {
                if (!input.value) {
                    input.classList.add('is-invalid');
                    valid = false;
                } else {
                    input.classList.remove('is-invalid');
                }
                
                // Validate radios
                if (input.type === 'radio' && input.name) {
                    const radios = document.querySelectorAll(`input[name="${input.name}"]`);
                    const checked = Array.from(radios).some(r => r.checked);
                    
                    if (!checked) {
                        radios.forEach(r => {
                            r.classList.add('is-invalid');
                        });
                        valid = false;
                    } else {
                        radios.forEach(r => {
                            r.classList.remove('is-invalid');
                        });
                    }
                }
            });
            
            return valid;
        }
        
        // Next/Previous button click handlers
        nextBtn.addEventListener('click', function() {
            if (validateSection(currentSection)) {
                currentSection++;
                showSection(currentSection);
                window.scrollTo(0, 0);
            } else {
                alert('Silakan isi semua field yang wajib diisi di bagian ini.');
            }
        });
        
        prevBtn.addEventListener('click', function() {
            currentSection--;
            showSection(currentSection);
            window.scrollTo(0, 0);
        });
        
        // Form submit handler
        document.getElementById('formulirPendaftaran').addEventListener('submit', function(e) {
            if (!validateSection(currentSection)) {
                e.preventDefault();
                alert('Silakan isi semua field yang wajib diisi di bagian ini.');
            }
        });
        
        // Initialize first section
        showSection(currentSection);
    });
</script>
@endpush