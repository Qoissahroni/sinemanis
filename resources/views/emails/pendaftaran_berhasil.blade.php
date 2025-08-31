<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pendaftaran</title>
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
        
        .success-message {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .success-icon {
            width: 50px;
            height: 50px;
            background: #27ae60;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: white;
            font-size: 24px;
        }
        
        .success-title {
            font-size: 22px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 8px;
        }
        
        .success-subtitle {
            font-size: 15px;
            color: #7f8c8d;
        }
        
        .greeting {
            font-size: 16px;
            color: #2c3e50;
            margin-bottom: 30px;
            line-height: 1.5;
        }
        
        .info-section {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 30px;
            margin-bottom: 30px;
        }
        
        .section-title {
            font-size: 16px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 20px;
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
            min-width: 120px;
        }
        
        .info-value {
            font-size: 14px;
            color: #2c3e50;
            font-weight: 500;
            text-align: right;
            flex: 1;
        }
        
        .status {
            background: #fff3cd;
            color: #856404;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
        }
        
        .next-steps {
            margin-bottom: 30px;
        }
        
        .steps-list {
            list-style: none;
            counter-reset: step-counter;
        }
        
        .steps-list li {
            counter-increment: step-counter;
            position: relative;
            padding: 12px 0 12px 50px;
            font-size: 15px;
            color: #2c3e50;
            line-height: 1.5;
        }
        
        .steps-list li::before {
            content: counter(step-counter);
            position: absolute;
            left: 0;
            top: 12px;
            width: 28px;
            height: 28px;
            background: #34495e;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 600;
        }
        
        .important-note {
            background: #fff5f5;
            border-left: 4px solid #e74c3c;
            padding: 20px;
            border-radius: 4px;
            margin-bottom: 30px;
        }
        
        .note-title {
            font-size: 15px;
            font-weight: 600;
            color: #c0392b;
            margin-bottom: 8px;
        }
        
        .note-text {
            font-size: 14px;
            color: #e74c3c;
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
        
        .contact-info {
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
            <div class="success-message">
                <div class="success-icon">✓</div>
                <div class="success-title">Pendaftaran Berhasil</div>
                <div class="success-subtitle">Formulir Anda telah tersimpan dalam sistem</div>
            </div>
            
            <div class="greeting">
                Halo <strong>{{ $pendaftar->name }}</strong>,<br>
                Terima kasih telah mendaftar di Universitas Selamat Sri. Berikut adalah ringkasan pendaftaran Anda:
            </div>
            
            <div class="info-section">
                <div class="section-title">Detail Pendaftaran</div>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Nama Lengkap</span>
                        <span class="info-value">{{ $pendaftar->name }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Email</span>
                        <span class="info-value">{{ $pendaftar->email }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">No. Handphone</span>
                        <span class="info-value">{{ $pendaftar->phone }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Program Studi</span>
                        <span class="info-value">{{ $pendaftar->prodi->nama ?? 'Belum dipilih' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Tanggal Daftar</span>
                        <span class="info-value">{{ $pendaftar->created_at->format('d M Y, H:i') }} WIB</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Status</span>
                        <span class="info-value">
                            <span class="status">Menunggu Verifikasi</span>
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="info-section next-steps">
                <div class="section-title">Langkah Selanjutnya</div>
                <ol class="steps-list">
                    <li>Lakukan pembayaran biaya pendaftaran sesuai program studi yang dipilih</li>
                    <li>Upload bukti pembayaran melalui dashboard mahasiswa</li>
                    <li>Tunggu proses verifikasi dari tim administrasi</li>
                    <li>Pantau status pendaftaran secara berkala di dashboard</li>
                </ol>
            </div>
            
            <div class="important-note">
                <div class="note-title">Catatan Penting</div>
                <div class="note-text">
                    Segera lakukan pembayaran dalam 3x24 jam untuk memastikan pendaftaran Anda diproses. 
                    Jika mengalami kendala, silakan hubungi tim kami.
                </div>
            </div>
        </div>
        
        <div class="footer">
            <div class="footer-text">
                Email ini dikirim secara otomatis oleh sistem SINEMANIS.<br>
                Mohon jangan membalas email ini.
            </div>
            <div class="contact-info">
                Universitas Selamat Sri<br>
                Jl. Raya Batang-Semarang Km.14 Clapar, Subah, Batang, Jawa Tengah 51263<br>
                Email: unissbatang12@gmail.com • Telp: (0294) 3689259
            </div>
        </div>
    </div>
</body>
</html>