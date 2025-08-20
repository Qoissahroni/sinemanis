<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftar extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'jenis_kelamin',
        'tanggal_lahir',
        'tempat_lahir',
        'nik',
        'agama',
        'nisn',
        'jenis_pendaftaran',
        'alamat',
        'jenis_tinggal',
        'alat_transportasi', 
        'kps', 
        'no_kps', 
        'bekerja', 
        'tempat_kerja',
        'penghasilan', 
        
        // Data Orang Tua/Wali
        'nik_ayah',
        'nama_ayah',
        'tanggal_lahir_ayah',
        'pendidikan_ayah',
        'pekerjaan_ayah',
        'penghasilan_ayah',
        'nik_ibu',
        'nama_ibu',
        'tanggal_lahir_ibu',
        'pekerjaan_ibu',
        'penghasilan_ibu',
        'nik_wali',
        'nama_wali',
        'tanggal_lahir_wali',
        'pekerjaan_wali',
        'penghasilan_wali',
        'no_hp_ortu',
        
        // Program Studi 
        'prodi_id',
        'kelas',
        'ukuran_almamater',
        'ukuran_kaos',
        
        // Data Sekolah 
        'asal_sekolah',
        'tahun_lulus',
        'asal_perguruan_tinggi',
        'asal_prodi',
        'semester_terakhir',
        'nilai_rata_rata',
        
        // Files 
        'berkas_url',
        'ijazah_url',
        'nilai_url',
        'foto_url',
        
        // Status
        'status',
        'keterangan',
        
        // FIELD PERGANTIAN PRODI
        'prodi_baru_id',
        'kelas_baru',
        'alasan_ganti_prodi',
        'selisih_biaya_prodi',
        'status_ganti_prodi',
        'sudah_ganti_prodi',
    ];
    
    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_lahir_ayah' => 'date', 
        'tanggal_lahir_ibu' => 'date', 
        'tanggal_lahir_wali' => 'date', 
        'sudah_ganti_prodi' => 'boolean', 
    ];
    
    /**
     * Get the user that owns the pendaftar.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get the prodi that the pendaftar is applying to.
     */
    public function prodi()
    {
        return $this->belongsTo(Prodi::class);
    }
    
    /**
     * Get the new prodi for transfer request.
     */
    public function prodiBaru()
    {
        return $this->belongsTo(Prodi::class, 'prodi_baru_id');
    }
    
    /**
     * Get the transaksi associated with the pendaftar.
     */
    public function transaksi()
    {
        return $this->hasOne(Transaksi::class);
    }
}