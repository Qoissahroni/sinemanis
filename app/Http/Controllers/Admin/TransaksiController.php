<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Transaksi;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Transaksi::with('pendaftar');
        
        // Filter berdasarkan status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        // Filter berdasarkan tanggal
        if ($request->has('start_date') && $request->start_date != '') {
            $query->whereDate('tanggal_bayar', '>=', $request->start_date);
        }
        
        if ($request->has('end_date') && $request->end_date != '') {
            $query->whereDate('tanggal_bayar', '<=', $request->end_date);
        }
        
        // Pencarian berdasarkan nomor transaksi atau nama pendaftar
        if ($request->has('search') && $request->search != '') {
            $query->where('nomor_transaksi', 'like', '%' . $request->search . '%')
                  ->orWhereHas('pendaftar', function($q) use ($request) {
                      $q->where('name', 'like', '%' . $request->search . '%');
                  });
        }
        
        $transaksis = $query->orderBy('created_at', 'desc')->simplepaginate(10);
        
        return view('admin.transaksi.index', compact('transaksis'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $transaksi = Transaksi::with('pendaftar.prodi')->findOrFail($id);
        return view('admin.transaksi.show', compact('transaksi'));
    }

    /**
     * Update the status of a specified resource.
     */
    public function updateStatus(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required|in:pending,success,failed',
            'keterangan' => 'nullable|string|max:255',
        ]);
        
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->status = $request->status;
        $transaksi->keterangan = $request->keterangan;
        $transaksi->status_updated_at = now(); // Tambahkan waktu update status
        $transaksi->save();
        
        // Jika transaksi berhasil, update status pendaftar menjadi verified jika masih pending
        if ($request->status == 'success') {
            $pendaftar = $transaksi->pendaftar;
            if ($pendaftar && $pendaftar->status == 'pending') {
                $pendaftar->status = 'verified';
                $pendaftar->save();
            }
        }
        
        return redirect()->route('admin.transaksi.show', $transaksi->id)
            ->with('success', 'Status transaksi berhasil diperbarui.');
    }
    
    /**
     * Download bukti pembayaran.
     */
    public function download(string $id)
    {
        $transaksi = Transaksi::findOrFail($id);
        
        if (!$transaksi->bukti_bayar_url) {
            return redirect()->back()->with('error', 'Tidak ada bukti pembayaran yang tersedia.');
        }
        
        $filePath = storage_path('app/public/' . $transaksi->bukti_bayar_url);
        
        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File bukti pembayaran tidak ditemukan.');
        }
        
        // Get original filename or generate one
        $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);
        $fileName = 'Bukti_Pembayaran_' . $transaksi->nomor_transaksi . '.' . $fileExtension;
        
        return response()->download($filePath, $fileName);
    }
}