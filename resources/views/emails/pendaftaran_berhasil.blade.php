<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pendaftaran</title>
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
            background: linear-gradient(135deg, #2E3192, #1BAEEC);
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
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 30px;
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
            background: #2E3192;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            color: #666;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>SINEMANIS</h1>
        <p>Sistem Penerimaan Mahasiswa Baru<br>Universitas Selamat Sri</p>
    </div>
    
    <div class="content">
        <div class="success-icon">✓</div>
        
        <h2 style="text-align: center; color: #2E3192;">Pendaftaran Berhasil!</h2>
        
        <p>Halo <strong>{{ $pendaftar->name }}</strong>,</p>
        
        <p>Selamat! Formulir pendaftaran Anda telah berhasil disimpan dalam sistem SINEMANIS. Berikut adalah detail pendaftaran Anda:</p>
        
        <div class="card">
            <h3 style="color: #2E3192; margin-top: 0;">Detail Pendaftaran</h3>
            
            <div class="info-row">
                <span class="label">Nama Lengkap:</span>
                <span class="value">{{ $pendaftar->name }}</span>
            </div>
            
            <div class="info-row">
                <span class="label">Email:</span>
                <span class="value">{{ $pendaftar->email }}</span>
            </div>
            
            <div class="info-row">
                <span class="label">No. HP:</span>
                <span class="value">{{ $pendaftar->phone }}</span>
            </div>
            
            <div class="info-row">
                <span class="label">Program Studi:</span>
                <span class="value">{{ $pendaftar->prodi->nama ?? 'Belum dipilih' }}</span>
            </div>
            
            <div class="info-row">
                <span class="label">Tanggal Pendaftaran:</span>
                <span class="value">{{ $pendaftar->created_at->format('d M Y, H:i') }} WIB</span>
            </div>
            
            <div class="info-row">
                <span class="label">Status:</span>
                <span class="value" style="color: #F58220; font-weight: bold;">Menunggu Verifikasi</span>
            </div>
        </div>
        
        <div class="card">
            <h3 style="color: #2E3192; margin-top: 0;">Langkah Selanjutnya</h3>
            <ol>
                <li>Lakukan pembayaran biaya pendaftaran</li>
                <li>Upload bukti pembayaran</li>
                <li>Tunggu verifikasi dari admin</li>
                <li>Pantau status pendaftaran di dashboard</li>
            </ol>
        </div>
        
        <p><strong>Penting:</strong></p>
        <ul>
            <li>Segera lakukan pembayaran untuk melanjutkan proses</li>
            <li>Hubungi admin jika ada pertanyaan</li>
        </ul>
    </div>
    
    <div class="footer">
        <p>Email ini dikirim otomatis oleh sistem SINEMANIS<br>
        Universitas Selamat Sri<br>
        Jl. Raya Batang-Semarang Km.14 Clapar, Subah, Batang, Jawa Tengah, Kode Pos 51263 <br>
        Email: unissbatang12@gmail.com | Telp. (0294) 3689259</p>
    </div>
</body>
</html>