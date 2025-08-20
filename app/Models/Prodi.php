<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'kode',
        'nama',
        'jenjang',
        'deskripsi',
        'kuota',
        'biaya',
        'akreditasi',
    ];
    
    /**
     * Get the pendaftar for the program studi.
     */
    public function pendaftar()
    {
        return $this->hasMany(Pendaftar::class);
    }
}