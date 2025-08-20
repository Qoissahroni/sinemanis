<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Pendaftaran - {{ $pendaftar->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap');
        
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
            padding: 20px;
            line-height: 1.6;
            color: #333;
        }
        
        /* Document Container */
        .dokumen-container {
            max-width: 21cm;
            margin: 0 auto;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        /* Header Section */
        .dokumen-header {
            padding: 25px 30px;
            background: linear-gradient(135deg, #2E3192, #1BAEEC);
            color: white;
            text-align: center;
            border-bottom: 5px solid #F58220;
        }
        
        .header-content {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
        }
        
        .university-logo {
            height: 80px;
        }
        
        .header-title h3 {
            font-weight: 700;
            margin-bottom: 5px;
            letter-spacing: 1px;
        }
        
        .header-title p {
            margin-bottom: 2px;
            font-size: 16px;
            letter-spacing: 0.5px;
        }
        
        .nomor-dokumen {
            font-size: 16px;
            margin-top: 15px;
            font-weight: 500;
            letter-spacing: 0.5px;
            background: rgba(255, 255, 255, 0.2);
            display: inline-block;
            padding: 3px 15px;
            border-radius: 20px;
        }
        
        /* Document Body */
        .dokumen-body {
            padding: 40px;
        }
        
        /* Status Box */
        .status-box {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 20px 25px;
            margin-bottom: 30px;
            border-left: 5px solid #2E3192;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .status-box h5 {
            font-weight: 600;
            margin-bottom: 8px;
            color: #2E3192;
            font-size: 16px;
        }
        
        .badge {
            font-size: 14px;
            padding: 7px 12px;
            border-radius: 5px;
        }
        
        /* Section Titles */
        .section-title {
            color: #2E3192;
            border-bottom: 2px solid #F58220;
            padding-bottom: 10px;
            margin-bottom: 25px;
            font-weight: 600;
            font-size: 18px;
            letter-spacing: 0.5px;
        }
        
        /* Data Containers */
        .data-container {
            margin-bottom: 40px;
        }
        
        .data-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }
        
        .data-table th, 
        .data-table td {
            padding: 12px 15px;
            text-align: left;
        }
        
        .data-table th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #495057;
            font-size: 14px;
            border-bottom: 1px solid #dee2e6;
        }
        
        .data-table td {
            font-weight: 500;
            border-bottom: 1px solid #f1f1f1;
        }
        
        .table-section {
            margin-bottom: 25px;
        }
        
        /* Footer */
        .dokumen-footer {
            margin-top: 50px;
            border-top: 1px dashed #dee2e6;
            padding-top: 30px;
        }
        
        .ttd-box {
            text-align: center;
            margin-left: auto;
        }
        
        .ttd-box p {
            margin-bottom: 5px;
        }
        
        /* Info Box */
        .info-box {
            background-color: #e7f2fa;
            border-radius: 8px;
            padding: 20px 25px;
            border-left: 4px solid #1BAEEC;
            margin-top: 30px;
        }
        
        .info-box h6 {
            color: #2E3192;
            margin-bottom: 10px;
            font-weight: 600;
        }
        
        .info-box ol {
            padding-left: 20px;
            margin-bottom: 0;
        }
        
        .info-box li {
            margin-bottom: 5px;
        }
        
        /* Print Styles */
        @media print {
            body {
                background-color: white;
                padding: 0;
            }
            
            .dokumen-container {
                box-shadow: none;
                border: none;
                max-width: 100%;
            }
            
            .no-print {
                display: none;
            }
            
            .status-box {
                break-inside: avoid;
            }
            
            .section-title, .data-container {
                break-inside: avoid;
            }
            
            .dokumen-footer {
                break-inside: avoid;
            }
            
            .table-section {
                break-inside: avoid;
            }
            
            @page {
                size: A4;
                margin: 1cm;
            }
        }
    </style>
</head>
<body>
    <div class="container mb-4 no-print">
        <div class="d-flex justify-content-between align-items-center">
            <h4>Bukti Pendaftaran Mahasiswa Baru</h4>
            <div>
                <button onclick="window.print()" class="btn btn-primary">
                    <i class="fas fa-print me-1"></i> Cetak
                </button>
                <a href="{{ route('user.laporan.index') }}" class="btn btn-secondary ms-2">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>
        <hr>
    </div>
    
    <div class="dokumen-container">
        <!-- Header -->
        <div class="dokumen-header">
            <div class="header-content">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Universitas" class="university-logo">
                <div class="header-title">
                    <h3>UNIVERSITAS SELAMAT SRI</h3>
                    <p>BUKTI PENDAFTARAN MAHASISWA BARU</p>
                    <p>TAHUN AKADEMIK {{ date('Y') }}/{{ date('Y')+1 }}</p>
                </div>
            </div>
            <div class="nomor-dokumen">Nomor: PMB-{{ str_pad($pendaftar->id, 5, '0', STR_PAD_LEFT) }}/{{ date('Y') }}</div>
        </div>
        
        <!-- Body -->
        <div class="dokumen-body">
            <!-- Status Box -->
            <div class="status-box">
                <div class="row">
                    <div class="col-md-6">
                        <h5>STATUS PENDAFTARAN</h5>
                        @if($pendaftar->status == 'pending')
                            <span class="badge bg-warning text-dark">MENUNGGU VERIFIKASI</span>
                        @elseif($pendaftar->status == 'verified')
                            <span class="badge bg-info">TERVERIFIKASI</span>
                        @elseif($pendaftar->status == 'accepted')
                            <span class="badge bg-success">DITERIMA</span>
                        @elseif($pendaftar->status == 'rejected')
                            <span class="badge bg-danger">DITOLAK</span>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <h5>STATUS PEMBAYARAN</h5>
                        @if($pendaftar->transaksi && $pendaftar->transaksi->status == 'success')
                            <span class="badge bg-success">LUNAS</span>
                        @else
                            <span class="badge bg-warning text-dark">BELUM LUNAS</span>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Data Mahasiswa -->
            <h5 class="section-title">DATA MAHASISWA</h5>
            <div class="data-container">
                <div class="table-section">
                    <table class="data-table">
                        <tbody>
                            <tr>
                                <th width="30%">Nama Lengkap</th>
                                <td width="70%">{{ $pendaftar->name }}</td>
                            </tr>
                            <tr>
                                <th>Tempat, Tanggal Lahir</th>
                                <td>{{ $pendaftar->tempat_lahir }}, {{ $pendaftar->tanggal_lahir->format('d M Y') }}</td>
                            </tr>
                            <tr>
                                <th>Jenis Kelamin</th>
                                <td>{{ $pendaftar->jenis_kelamin }}</td>
                            </tr>
                            <tr>
                                <th>NIK</th>
                                <td>{{ $pendaftar->nik }}</td>
                            </tr>
                            <tr>
                                <th>NISN</th>
                                <td>{{ $pendaftar->nisn }}</td>
                            </tr>
                            <tr>
                                <th>No. HP</th>
                                <td>{{ $pendaftar->phone }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $pendaftar->email }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Daftar</th>
                                <td>{{ $pendaftar->created_at->format('d M Y') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Data Pendidikan -->
            <h5 class="section-title">DATA PENDIDIKAN</h5>
            <div class="data-container">
                <div class="table-section">
                    <table class="data-table">
                        <tbody>
                            <tr>
                                <th width="30%">Asal Sekolah</th>
                                <td width="70%">{{ $pendaftar->asal_sekolah }}</td>
                            </tr>
                            <tr>
                                <th>Tahun Lulus</th>
                                <td>{{ $pendaftar->tahun_lulus }}</td>
                            </tr>
                            @if($pendaftar->jenis_pendaftaran == 'Pindahan')
                                <tr>
                                    <th>Asal Perguruan Tinggi</th>
                                    <td>{{ $pendaftar->asal_perguruan_tinggi }}</td>
                                </tr>
                                <tr>
                                    <th>Asal Program Studi</th>
                                    <td>{{ $pendaftar->asal_prodi }}</td>
                                </tr>
                                <tr>
                                    <th>Semester Terakhir</th>
                                    <td>{{ $pendaftar->semester_terakhir }}</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Program Studi Pilihan -->
            <h5 class="section-title">PROGRAM STUDI PILIHAN</h5>
            <div class="data-container">
                <div class="table-section">
                    <table class="data-table">
                        <tbody>
                            <tr>
                                <th width="30%">Program Studi</th>
                                <td width="70%">{{ $pendaftar->prodi->nama ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Jenjang</th>
                                <td>{{ $pendaftar->prodi->jenjang ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Kelas</th>
                                <td>{{ $pendaftar->kelas ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Ukuran Almamater</th>
                                <td>{{ $pendaftar->ukuran_almamater }}</td>
                            </tr>
                            <tr>
                                <th>Ukuran Kaos PKKMB</th>
                                <td>{{ $pendaftar->ukuran_kaos }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Informasi Pembayaran -->
            <h5 class="section-title">INFORMASI PEMBAYARAN</h5>
            <div class="data-container">
                @if($pendaftar->transaksi)
                    <div class="table-section">
                        <table class="data-table">
                            <tbody>
                                <tr>
                                    <th width="30%">Nomor Transaksi</th>
                                    <td width="70%">{{ $pendaftar->transaksi->nomor_transaksi }}</td>
                                </tr>
                                <tr>
                                    <th>Metode Pembayaran</th>
                                    <td>{{ $pendaftar->transaksi->metode_pembayaran }}</td>
                                </tr>
                                <tr>
                                    <th>Jumlah Pembayaran</th>
                                    <td>Rp {{ number_format($pendaftar->transaksi->jumlah, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Pembayaran</th>
                                    <td>{{ $pendaftar->transaksi->tanggal_bayar->format('d M Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Status Pembayaran</th>
                                    <td>
                                        @if($pendaftar->transaksi->status == 'pending')
                                            <span class="badge bg-warning text-dark">MENUNGGU KONFIRMASI</span>
                                        @elseif($pendaftar->transaksi->status == 'success')
                                            <span class="badge bg-success">LUNAS</span>
                                        @elseif($pendaftar->transaksi->status == 'failed')
                                            <span class="badge bg-danger">GAGAL</span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-center text-muted">Data pembayaran tidak ditemukan.</p>
                @endif
            </div>
            
            <!-- Informasi Penting -->
            <div class="info-box">
                <h6><i class="fas fa-info-circle me-2"></i> INFORMASI PENTING</h6>
                <ol>
                    <li>Bukti pendaftaran ini WAJIB dibawa saat proses daftar ulang.</li>
                    <li>Proses daftar ulang dilakukan pada tanggal <strong>10-20 Agustus 2025</strong>.</li>
                    <li>Kegiatan PKKMB akan dilaksanakan pada tanggal <strong>25-30 Agustus 2025</strong>.</li>
                    <li>Untuk informasi lebih lanjut, silakan hubungi panitia PMB di nomor <strong>082122790309</strong>.</li>
                </ol>
            </div>
            
            <!-- Footer -->
            <div class="dokumen-footer">
                <div class="row">
                    <div class="col-md-7">
                        <p>Dokumen ini dicetak pada tanggal <strong>{{ date('d M Y') }}</strong> dan merupakan bukti sah pendaftaran mahasiswa baru Universitas Selamat Sri.</p>
                    </div>
                    <div class="col-md-5">
                        <div class="ttd-box">
                            <p>Batang, {{ date('d M Y') }}</p>
                            <p>Panitia PMB</p>
                            <br><br>
                            <p><u>___________________</u></p>
                            <p>Ketua Panitia</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>