<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengumuman Penerimaan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #f8f9fc;
            padding: 30px;
            border-radius: 0 0 10px 10px;
        }
        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .success-icon {
            background: #28a745;
            color: white;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 40px;
        }
        .celebration {
            text-align: center;
            font-size: 50px;
            margin: 20px 0;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .label {
            font-weight: bold;
            color: #666;
        }
        .value {
            color: #333;
        }
        .button {
            background: #28a745;
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin: 20px 0;
            font-weight: bold;
        }
        .highlight-box {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            color: #666;
            font-size: 14px;
        }
        .important-info {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🎓 SELAMAT! 🎓</h1>
        <h2>UNIVERSITAS SELAMAT SRI</h2>
        <p>Sistem Penerimaan Mahasiswa Baru (SINEMANIS)</p>
    </div>
    
    <div class="content">
        <div class="celebration">🎉 🎊 🎉</div>
        
        <div class="success-icon">✓</div>
        
        <div class="highlight-box">
            <h2 style="margin: 0;">ANDA DITERIMA!</h2>
            <p style="margin: 10px 0 0 0; font-size: 18px;">Selamat bergabung dengan keluarga besar Universitas Selamat Sri</p>
        </div>
        
        <p>Yang terhormat <strong>{{ $pendaftar->name }}</strong>,</p>
        
        <p style="font-size: 16px;">Dengan bangga kami informasikan bahwa Anda telah <strong>DITERIMA</strong> sebagai mahasiswa baru di Universitas Selamat Sri untuk tahun akademik 2025/2026.</p>
        
        <div class="card">
            <h3 style="color: #28a745; margin-top: 0;">📋 Detail Penerimaan</h3>
            
            <div class="info-row">
                <span class="label">Nama Lengkap:</span>
                <span class="value">{{ $pendaftar->name }}</span>
            </div>
            
            <div class="info-row">
                <span class="label">Program Studi:</span>
                <span class="value"><strong>{{ $pendaftar->prodi->nama ?? 'Tidak tersedia' }} ({{ $pendaftar->prodi->jenjang ?? '' }})</strong></span>
            </div>
            
            <div class="info-row">
                <span class="label">Kelas:</span>
                <span class="value">{{ $pendaftar->kelas ?? 'Reguler' }}</span>
            </div>
            
            <div class="info-row">
                <span class="label">Status:</span>
                <span class="value" style="color: #28a745; font-weight: bold;">✅ DITERIMA</span>
            </div>
            
            <div class="info-row">
                <span class="label">Tanggal Pengumuman:</span>
                <span class="value">{{ now()->format('d M Y, H:i') }} WIB</span>
            </div>
        </div>
        
        <div class="important-info">
            <h3 style="color: #856404; margin-top: 0;">⚠️ PENTING - Langkah Selanjutnya:</h3>
            <ol style="margin: 10px 0;">
                <li><strong>Daftar Ulang:</strong> 10 - 20 Agustus 2025</li>
                <li><strong>PKKMB:</strong> 25 - 30 Agustus 2025</li>
                <li><strong>Perkuliahan Dimulai:</strong> 1 September 2025</li>
                <li><strong>Batas Konfirmasi:</strong> 25 Agustus 2025</li>
            </ol>
        </div>
        
        <div style="background: #e7f3ff; padding: 15px; border-radius: 5px; margin: 20px 0;">
            <p style="margin: 0;"><strong>📞 Informasi Lebih Lanjut:</strong></p>
            <p style="margin: 5px 0 0 0;">Hubungi +62 821 2279 0309 atau email ke unissbatang12@gmail.com</p>
        </div>
        
    </div>
    
    <div class="footer">
        <p>Email ini dikirim otomatis oleh sistem SINEMANIS<br>
        <strong>Universitas Selamat Sri</strong><br>
        Jl. Raya Batang-Semarang Km.14 Clapar, Subah, Batang, Jawa Tengah, Kode Pos 51263<br>
        📧 unissbatang12@gmail.com | 📞 (0294) 3689259</p>
        
    </div>
</body>
</html>