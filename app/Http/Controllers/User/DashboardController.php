<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pendaftar;
use App\Models\Transaksi;

class DashboardController extends Controller
{
   public function index()
   {
       $user = Auth::user();
       $pendaftar = Pendaftar::where('user_id', $user->id)->first();
       
       // Timeline status
       $timelineStatus = [
           'register' => 'completed', // User is registered
           'formulir' => 'pending',
           'payment' => 'pending',
           'verification' => 'pending',
           'result' => 'pending'
       ];
       
       // Check formulir status
       if ($pendaftar) {
           $timelineStatus['formulir'] = 'completed';
           
           // Check payment status
           $transaksi = Transaksi::where('pendaftar_id', $pendaftar->id)->first();
           if ($transaksi) {
               if ($transaksi->status == 'success') {
                   $timelineStatus['payment'] = 'completed';
                   
                   // Check verification status
                   if ($pendaftar->status == 'verified' || $pendaftar->status == 'accepted' || $pendaftar->status == 'rejected') {
                       $timelineStatus['verification'] = 'completed';
                       
                       // Check result status
                       if ($pendaftar->status == 'accepted' || $pendaftar->status == 'rejected') {
                           $timelineStatus['result'] = 'completed';
                       } else {
                           $timelineStatus['result'] = 'active';
                       }
                   } else {
                       $timelineStatus['verification'] = 'active';
                   }
               } else {
                   $timelineStatus['payment'] = 'active';
               }
           } else {
               $timelineStatus['formulir'] = 'active';
           }
           
           // TAMBAHAN: Jika ada pergantian prodi yang disetujui, status tetap seperti semula
           // Dashboard tidak berubah, hanya data prodi yang update
           if ($pendaftar->status_ganti_prodi == 'approved' && $pendaftar->sudah_ganti_prodi) {
               // Status timeline tetap sama, tidak ada perubahan
               // Data prodi sudah otomatis update di database
           }
       }
       
       return view('user.dashboard', compact('pendaftar', 'timelineStatus'));
   }
}