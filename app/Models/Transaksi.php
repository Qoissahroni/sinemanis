<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'pendaftar_id',
        'nomor_transaksi',
        'jumlah',
        'tanggal_bayar',
        'metode_pembayaran',
        'bukti_bayar_url',
        'status',
        'keterangan',
    ];
    
    protected $casts = [
        'tanggal_bayar' => 'datetime',
    ];
    
    /**
     * Get the pendaftar that owns the transaksi.
     */
    public function pendaftar()
    {
        return $this->belongsTo(Pendaftar::class);
    }
}