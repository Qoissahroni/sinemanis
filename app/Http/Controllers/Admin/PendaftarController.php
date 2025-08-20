<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail; 
use Illuminate\Support\Facades\Storage;
use App\Models\Pendaftar;
use App\Models\Prodi;
use App\Mail\PendaftarDiterima;

class PendaftarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Pendaftar::with('prodi');
        
        // Filter berdasarkan status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        // Filter berdasarkan program studi
        if ($request->has('prodi_id') && $request->prodi_id != '') {
            $query->where('prodi_id', $request->prodi_id);
        }
        
        // Pencarian berdasarkan nama atau email
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }
        
        $pendaftars = $query->orderBy('created_at', 'desc')->paginate(10);
        $prodis = Prodi::all();
        
        return view('admin.pendaftar.index', compact('pendaftars', 'prodis'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pendaftar = Pendaftar::with(['prodi', 'transaksi'])->findOrFail($id);
        return view('admin.pendaftar.show', compact('pendaftar'));
    }

    /**
     * Update the status of a specified resource.
     */
    public function updateStatus(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required|in:pending,verified,accepted,rejected',
            'keterangan' => 'nullable|string|max:255',
        ]);
        
        $pendaftar = Pendaftar::findOrFail($id);
        $statusLama = $pendaftar->status;
        $pendaftar->status = $request->status;
        $pendaftar->keterangan = $request->keterangan;
        $pendaftar->save();

        // TAMBAHKAN KODE INI DI SINI
        if ($statusLama != 'accepted' && $request->status == 'accepted') {
            try {
                Mail::to($pendaftar->email)->send(new PendaftarDiterima($pendaftar));
            } catch (\Exception $e) {
                // Jika email gagal dikirim, tetap lanjutkan proses
            }
        }
        
        return redirect()->route('admin.pendaftar.show', $pendaftar->id)
        ->with('success', 'Status pendaftar berhasil diperbarui.' . ($request->status == 'accepted' ? ' Email penerimaan telah dikirim.' : ''));
    }
    
    /**
 * Remove the specified resource from storage.
 */
public function destroy(string $id)
{
    $pendaftar = Pendaftar::findOrFail($id);
    
    // Delete related files if exist
    if ($pendaftar->berkas_url && Storage::exists('public/' . $pendaftar->berkas_url)) {
        Storage::delete('public/' . $pendaftar->berkas_url);
    }
    
    if ($pendaftar->foto_url && Storage::exists('public/' . $pendaftar->foto_url)) {
        Storage::delete('public/' . $pendaftar->foto_url);
    }
    
    // Delete related transaction if exists
    if ($pendaftar->transaksi) {
        if ($pendaftar->transaksi->bukti_bayar_url && Storage::exists('public/' . $pendaftar->transaksi->bukti_bayar_url)) {
            Storage::delete('public/' . $pendaftar->transaksi->bukti_bayar_url);
        }
        $pendaftar->transaksi->delete();
    }
    
    // Delete the pendaftar
    $nama = $pendaftar->name;
    $pendaftar->delete();
    
    return redirect()->route('admin.pendaftar.index')
        ->with('success', 'Data pendaftar "' . $nama . '" berhasil dihapus.');
}
    /**
     * View file berkas pendaftaran
     */
    public function viewBerkas(string $id)
    {
        $pendaftar = Pendaftar::findOrFail($id);
        
        if (!$pendaftar->berkas_url || !Storage::disk('public')->exists($pendaftar->berkas_url)) {
            return redirect()->back()->with('error', 'Berkas pendaftaran tidak ditemukan.');
        }
        
        return response()->file(storage_path('app/public/' . $pendaftar->berkas_url));
    }
    
    /**
     * Download file berkas pendaftaran
     */
    public function downloadBerkas(string $id)
    {
        $pendaftar = Pendaftar::findOrFail($id);
        
        if (!$pendaftar->berkas_url || !Storage::disk('public')->exists($pendaftar->berkas_url)) {
            return redirect()->back()->with('error', 'Berkas pendaftaran tidak ditemukan.');
        }
        
        return Storage::disk('public')->download($pendaftar->berkas_url, 'Berkas_Pendaftaran_' . $pendaftar->name . '.pdf');
    }
    
    /**
     * View pas foto
     */
    public function viewFoto(string $id)
    {
        $pendaftar = Pendaftar::findOrFail($id);
        
        if (!$pendaftar->foto_url || !Storage::disk('public')->exists($pendaftar->foto_url)) {
            return redirect()->back()->with('error', 'Pas foto tidak ditemukan.');
        }
        
        return response()->file(storage_path('app/public/' . $pendaftar->foto_url));
    }
    
    /**
     * Download pas foto
     */
    public function downloadFoto(string $id)
    {
        $pendaftar = Pendaftar::findOrFail($id);
        
        if (!$pendaftar->foto_url || !Storage::disk('public')->exists($pendaftar->foto_url)) {
            return redirect()->back()->with('error', 'Pas foto tidak ditemukan.');
        }
        
        // Dapatkan ekstensi file asli
        $extension = pathinfo($pendaftar->foto_url, PATHINFO_EXTENSION);
        
        return Storage::disk('public')->download($pendaftar->foto_url, 'Pas_Foto_' . $pendaftar->name . '.' . $extension);
    }

    // TAMBAHKAN METHOD BARU INI DI AKHIR CLASS PendaftarController
    
    /**
     * Approve pergantian prodi
     */
    public function approveGantiProdi(string $id)
    {
        $pendaftar = Pendaftar::findOrFail($id);
        
        if ($pendaftar->status_ganti_prodi != 'pending') {
            return redirect()->back()->with('error', 'Pengajuan pergantian prodi tidak dalam status pending.');
        }
        
        // Update prodi dan kelas ke yang baru
        $pendaftar->prodi_id = $pendaftar->prodi_baru_id;
        $pendaftar->kelas = $pendaftar->kelas_baru;
        $pendaftar->status_ganti_prodi = 'approved';
        $pendaftar->sudah_ganti_prodi = true;
        
        // Create new transaction if there's additional cost
        if ($pendaftar->selisih_biaya_prodi > 0) {
            $nomorTransaksi = 'TRX-SELISIH-' . date('Ymd') . '-' . str_pad($pendaftar->id, 4, '0', STR_PAD_LEFT);
            
            \App\Models\Transaksi::create([
                'pendaftar_id' => $pendaftar->id,
                'nomor_transaksi' => $nomorTransaksi,
                'jumlah' => $pendaftar->selisih_biaya_prodi,
                'tanggal_bayar' => now(),
                'metode_pembayaran' => 'Transfer Bank',
                'status' => 'pending',
                'keterangan' => 'Pembayaran selisih biaya pergantian prodi'
            ]);
        }
        
        $pendaftar->save();
        
        
        return redirect()->route('admin.pendaftar.index')
            ->with('success', 'Pergantian program studi berhasil disetujui.');
    }
    
    /**
     * Reject pergantian prodi
     */
    public function rejectGantiProdi(string $id)
    {
        $pendaftar = Pendaftar::findOrFail($id);
        
        if ($pendaftar->status_ganti_prodi != 'pending') {
            return redirect()->back()->with('error', 'Pengajuan pergantian prodi tidak dalam status pending.');
        }
        
        $pendaftar->status_ganti_prodi = 'rejected';
        $pendaftar->save();
        
        return redirect()->route('admin.pendaftar.index')
            ->with('success', 'Pengajuan pergantian program studi ditolak.');
    }
}