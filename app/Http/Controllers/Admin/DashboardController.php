<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Prodi;
use App\Models\Pendaftar;
use App\Models\Transaksi;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik pendaftar
        $totalPendaftar = Pendaftar::count();
        $pendaftarTerverifikasi = Pendaftar::where('status', 'verified')->count();
        $pendaftarDiterima = Pendaftar::where('status', 'accepted')->count();
        $pendaftarMenunggu = Pendaftar::where('status', 'pending')->count();
        
        // Pendaftar terbaru
        $pendaftarTerbaru = Pendaftar::with('prodi')
                                ->orderBy('created_at', 'desc')
                                ->take(5)
                                ->get();
        
        return view('admin.dashboard.dashboard', compact(
            'totalPendaftar',
            'pendaftarTerverifikasi',
            'pendaftarDiterima',
            'pendaftarMenunggu',
            'pendaftarTerbaru'
        ));
    }
}