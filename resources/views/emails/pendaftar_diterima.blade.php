<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengumuman Penerimaan</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #2c3e50;
            background-color: #f8f9fa;
            padding: 40px 20px;
        }
        
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }
        
        .header {
            padding: 40px 40px 30px;
            text-align: center;
            background: #ffffff;
            border-bottom: 1px solid #e9ecef;
        }
        
        .university-name {
            font-size: 24px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }
        
        .university-subtitle {
            font-size: 14px;
            color: #7f8c8d;
            font-weight: 400;
        }
        
        .content {
            padding: 40px;
        }
        
        .acceptance-message {
            text-align: center;
            margin-bottom: 40px;
            padding: 30px 0;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 12px;
            border: 1px solid #e9ecef;
        }
        
        .success-icon {
            width: 60px;
            height: 60px;
            background: #0D47A1;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: white;
            font-size: 28px;
        }
        
        .acceptance-title {
            font-size: 28px;
            font-weight: 700;
            color: #0D47A1;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }
        
        .acceptance-subtitle {
            font-size: 16px;
            color: #7f8c8d;
            font-weight: 400;
        }
        
        .greeting {
            font-size: 16px;
            color: #2c3e50;
            margin-bottom: 20px;
            line-height: 1.6;
        }
        
        .main-message {
            font-size: 17px;
            color: #2c3e50;
            margin-bottom: 35px;
            line-height: 1.6;
            text-align: center;
            padding: 25px;
            background: #f8f9fa;
            border-radius: 8px;
            border-left: 4px solid #0D47A1;
        }
        
        .info-section {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 30px;
            margin-bottom: 30px;
        }
        
        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .info-grid {
            display: grid;
            gap: 16px;
        }
        
        .info-item {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding-bottom: 16px;
            border-bottom: 1px solid #e9ecef;
        }
        
        .info-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }
        
        .info-label {
            font-size: 14px;
            color: #7f8c8d;
            font-weight: 500;
            min-width: 140px;
        }
        
        .info-value {
            font-size: 14px;
            color: #2c3e50;
            font-weight: 500;
            text-align: right;
            flex: 1;
        }
        
        .status-accepted {
            background: #d4d8ed;
            color: #0D47A1;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        
        .next-steps {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 25px;
            margin-bottom: 30px;
        }
        
        .next-steps-title {
            font-size: 16px;
            font-weight: 600;
            color: #856404;
            margin-bottom: 15px;
        }
        
        .timeline {
            list-style: none;
            position: relative;
        }
        
        .timeline::before {
            content: '';
            position: absolute;
            left: 15px;
            top: 8px;
            bottom: 8px;
            width: 2px;
            background: #ffd43b;
        }
        
        .timeline-item {
            position: relative;
            padding: 8px 0 8px 40px;
            color: #856404;
            font-size: 15px;
        }
        
        .timeline-item::before {
            content: '';
            position: absolute;
            left: 11px;
            top: 12px;
            width: 8px;
            height: 8px;
            background: #ffd43b;
            border-radius: 50%;
        }
        
        .timeline-date {
            font-weight: 600;
        }
        
        .contact-section {
            background: #e7f3ff;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
        }
        
        .contact-title {
            font-size: 15px;
            font-weight: 600;
            color: #0c5aa6;
            margin-bottom: 8px;
        }
        
        .contact-info {
            font-size: 14px;
            color: #0c5aa6;
            line-height: 1.5;
        }
        
        .footer {
            background: #f8f9fa;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e9ecef;
        }
        
        .footer-text {
            font-size: 13px;
            color: #7f8c8d;
            line-height: 1.6;
        }
        
        .contact-details {
            margin-top: 15px;
            font-size: 12px;
            color: #95a5a6;
        }
        
        @media (max-width: 480px) {
            body {
                padding: 20px 10px;
            }
            
            .header {
                padding: 30px 20px;
            }
            
            .content {
                padding: 30px 20px;
            }
            
            .info-section {
                padding: 20px;
            }
            
            .next-steps {
                padding: 20px;
            }
            
            .contact-section {
                padding: 15px;
            }
            
            .info-item {
                flex-direction: column;
                gap: 4px;
            }
            
            .info-label {
                min-width: auto;
            }
            
            .info-value {
                text-align: left;
            }
            
            .acceptance-title {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="university-name">Universitas Selamat Sri</div>
            <div class="university-subtitle">Sistem Penerimaan Mahasiswa Baru (SINEMANIS)</div>
        </div>
        
        <div class="content">
            <div class="acceptance-message">
                <div class="success-icon">✓</div>
                <div class="acceptance-title">Selamat, Anda Diterima!</div>
                <div class="acceptance-subtitle">Selamat bergabung dengan keluarga besar Universitas Selamat Sri</div>
            </div>
            
            <div class="greeting">
                Yang terhormat <strong>{{ $pendaftar->name }}</strong>,
            </div>
            
            <div class="main-message">
                Dengan bangga kami informasikan bahwa Anda telah <strong>diterima</strong> sebagai mahasiswa baru di Universitas Selamat Sri untuk tahun akademik <strong>2025/2026</strong>.
            </div>
            
            <div class="info-section">
                <div class="section-title">Detail Penerimaan</div>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Nama Lengkap</span>
                        <span class="info-value">{{ $pendaftar->name }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Program Studi</span>
                        <span class="info-value"><strong>{{ $pendaftar->prodi->nama ?? 'Tidak tersedia' }}</strong></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Jenjang</span>
                        <span class="info-value">{{ $pendaftar->prodi->jenjang ?? 'Sarjana' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Kelas</span>
                        <span class="info-value">{{ $pendaftar->kelas ?? 'Reguler' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Status</span>
                        <span class="info-value">
                            <span class="status-accepted">✓ Diterima</span>
                        </span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Tanggal Pengumuman</span>
                        <span class="info-value">{{ now()->format('d M Y, H:i') }} WIB</span>
                    </div>
                </div>
            </div>
            
            <div class="next-steps">
                <div class="next-steps-title">Langkah Selanjutnya</div>
                <ol class="timeline">
                    <li class="timeline-item">
                        <span class="timeline-date">Daftar Ulang:</span> 10 - 20 Agustus 2025
                    </li>
                    <li class="timeline-item">
                        <span class="timeline-date">PKKMB:</span> 25 - 30 Agustus 2025
                    </li>
                    <li class="timeline-item">
                        <span class="timeline-date">Perkuliahan Dimulai:</span> 1 September 2025
                    </li>
                    <li class="timeline-item">
                        <span class="timeline-date">Batas Konfirmasi:</span> 25 Agustus 2025
                    </li>
                </ol>
            </div>
            
            <div class="contact-section">
                <div class="contact-title">Informasi Lebih Lanjut</div>
                <div class="contact-info">
                    Hubungi +62 821 2279 0309 atau kirim email ke unissbatang12@gmail.com untuk bantuan lebih lanjut mengenai proses daftar ulang dan persiapan perkuliahan.
                </div>
            </div>
        </div>
        
        <div class="footer">
            <div class="footer-text">
                Email ini dikirim secara otomatis oleh sistem SINEMANIS.<br>
                Mohon jangan membalas email ini.
            </div>
            <div class="contact-details">
                <strong>Universitas Selamat Sri</strong><br>
                Jl. Raya Batang-Semarang Km.14 Clapar, Subah, Batang, Jawa Tengah 51263<br>
                Email: unissbatang12@gmail.com • Telp: (0294) 3689259
            </div>
        </div>
    </div>
</body>
</html>