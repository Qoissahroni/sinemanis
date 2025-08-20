<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pendaftar;
use App\Models\Transaksi;

class LaporanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $pendaftar = Pendaftar::with(['prodi', 'transaksi'])
                        ->where('user_id', $user->id)
                        ->first();
        
        // Check if pendaftar exists
        if (!$pendaftar) {
            return redirect()->route('user.formulir.index')
                ->with('error', 'Anda harus mengisi formulir pendaftaran terlebih dahulu.');
        }
        
        return view('user.laporan.index', compact('pendaftar'));
    }
    
    public function kartuPendaftaran()
    {
        $user = Auth::user();
        $pendaftar = Pendaftar::with(['prodi', 'transaksi'])
                        ->where('user_id', $user->id)
                        ->first();
        
        // Check if pendaftar exists
        if (!$pendaftar) {
            return redirect()->route('user.formulir.index')
                ->with('error', 'Anda harus mengisi formulir pendaftaran terlebih dahulu.');
        }
        
        return view('user.laporan.kartu_pendaftaran', compact('pendaftar'));
    }
    
    public function buktiPendaftaran()
    {
        $user = Auth::user();
        $pendaftar = Pendaftar::with(['prodi', 'transaksi'])
                        ->where('user_id', $user->id)
                        ->first();
        
        // Check if pendaftar exists
        if (!$pendaftar) {
            return redirect()->route('user.formulir.index')
                ->with('error', 'Anda harus mengisi formulir pendaftaran terlebih dahulu.');
        }
        
        // Check if payment exists and is verified
        if (!$pendaftar->transaksi || $pendaftar->transaksi->status != 'success') {
            return redirect()->route('user.pembayaran.index')
                ->with('error', 'Anda harus melakukan pembayaran terlebih dahulu.');
        }
        
        return view('user.laporan.bukti_pendaftaran', compact('pendaftar'));
    }
}