<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PendaftarController;
use App\Http\Controllers\Admin\TransaksiController as AdminTransaksiController;
use App\Http\Controllers\Admin\ProdiController;
use App\Http\Controllers\Admin\LaporanController as AdminLaporanController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Middleware\AdminMiddleware;

// Import User Controllers
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\FormulirController;
use App\Http\Controllers\User\PembayaranController;
use App\Http\Controllers\User\PembayaranSelisihController;
use App\Http\Controllers\User\LaporanController as UserLaporanController;
use App\Http\Controllers\User\ProfileController as UserProfileController;

// Homepage 
Route::get('/', function () {
    return view('landing');
})->name('home');

// Login page route
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Register page route  
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// Authentication Routes
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Admin Routes - Gunakan AdminMiddleware tanpa namespace lengkap
Route::middleware(['auth', AdminMiddleware::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        // Pendaftar (Registrant Management)
        Route::get('/pendaftar', [PendaftarController::class, 'index'])->name('pendaftar.index');
        Route::get('/pendaftar/{id}', [PendaftarController::class, 'show'])->name('pendaftar.show');
        Route::put('/pendaftar/{id}/status', [PendaftarController::class, 'updateStatus'])->name('pendaftar.update-status');
        Route::delete('/pendaftar/{id}', [PendaftarController::class, 'destroy'])->name('pendaftar.destroy');
        Route::put('/pendaftar/{id}/approve-ganti-prodi', [PendaftarController::class, 'approveGantiProdi'])->name('pendaftar.approve-ganti-prodi');
        Route::put('/pendaftar/{id}/reject-ganti-prodi', [PendaftarController::class, 'rejectGantiProdi'])->name('pendaftar.reject-ganti-prodi');
        
        // Berkas routes - Routes baru untuk berkas
        Route::get('/pendaftar/{id}/berkas/view', [PendaftarController::class, 'viewBerkas'])->name('pendaftar.berkas.view');
        Route::get('/pendaftar/{id}/berkas/download', [PendaftarController::class, 'downloadBerkas'])->name('pendaftar.berkas.download');
        Route::get('/pendaftar/{id}/foto/view', [PendaftarController::class, 'viewFoto'])->name('pendaftar.foto.view');
        Route::get('/pendaftar/{id}/foto/download', [PendaftarController::class, 'downloadFoto'])->name('pendaftar.foto.download');
        
        // Transaksi (Transaction Data)
        Route::get('/transaksi', [AdminTransaksiController::class, 'index'])->name('transaksi.index');
        Route::get('/transaksi/{id}', [AdminTransaksiController::class, 'show'])->name('transaksi.show');
        Route::put('/transaksi/{id}/status', [AdminTransaksiController::class, 'updateStatus'])->name('transaksi.update-status');
        Route::get('/transaksi/{id}/download', [AdminTransaksiController::class, 'download'])->name('transaksi.download'); // Rute baru untuk download
        
        // Program Studi (Study Program Management)
        Route::resource('prodi', ProdiController::class)->except(['show']);
        
       // Laporan & Statistik (Reports & Statistics)
        Route::get('/laporan', [AdminLaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/pendaftar-periode', [AdminLaporanController::class, 'pendaftarPeriode'])->name('laporan.pendaftar-periode');
        Route::get('/laporan/detail/{prodi}', [AdminLaporanController::class, 'detailProdi'])->name('laporan.detail-prodi');
                
        // Profil Admin (Admin Profile)
        Route::get('/profile', [AdminProfileController::class, 'index'])->name('profile');
        Route::put('/profile', [AdminProfileController::class, 'update'])->name('profile.update');
        Route::get('/profile/password', [AdminProfileController::class, 'showPasswordForm'])->name('profile.password');
        Route::put('/profile/password', [AdminProfileController::class, 'updatePassword'])->name('profile.password.update');
    });

// User Routes (Calon Mahasiswa)
Route::middleware(['auth'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {
        // Dashboard
        Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
        
        // Formulir Pendaftaran
        Route::get('/formulir', [FormulirController::class, 'index'])->name('formulir.index');
        Route::post('/formulir', [FormulirController::class, 'store'])->name('formulir.store');
        Route::put('/formulir', [FormulirController::class, 'update'])->name('formulir.update');
        
        Route::post('/formulir/ganti-prodi', [FormulirController::class, 'gantiProdi'])->name('formulir.ganti-prodi');
        
        // Pembayaran
        Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.index');
        Route::post('/pembayaran', [PembayaranController::class, 'store'])->name('pembayaran.store');
        Route::get('/pembayaran/selisih', [PembayaranSelisihController::class, 'index'])->name('pembayaran-selisih.index');
        Route::post('/pembayaran/selisih', [PembayaranSelisihController::class, 'store'])->name('pembayaran-selisih.store');
        
        // Laporan
        Route::get('/laporan', [UserLaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/kartu-pendaftaran', [UserLaporanController::class, 'kartuPendaftaran'])->name('laporan.kartu-pendaftaran');
        Route::get('/laporan/bukti-pendaftaran', [UserLaporanController::class, 'buktiPendaftaran'])->name('laporan.bukti-pendaftaran');
        
        // Profil
        Route::get('/profile', [UserProfileController::class, 'index'])->name('profile');
        Route::put('/profile', [UserProfileController::class, 'update'])->name('profile.update');
        Route::get('/profile/password', [UserProfileController::class, 'showPasswordForm'])->name('profile.password');
        Route::put('/profile/password', [UserProfileController::class, 'updatePassword'])->name('profile.password.update');
    });

// Main Dashboard Redirect
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        // Redirect admin ke dashboard admin
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        
        // Redirect user regular ke dashboard user
        return redirect()->route('user.dashboard');
    })->name('dashboard');
});