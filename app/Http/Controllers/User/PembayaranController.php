<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Pendaftar;
use App\Models\Transaksi;
use Midtrans\Config;
use Midtrans\Snap;

class PembayaranController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    public function index()
    {
        $user = Auth::user();
        $pendaftar = Pendaftar::where('user_id', $user->id)->first();
        
        // Check if pendaftar exists
        if (!$pendaftar) {
            return redirect()->route('user.formulir.index')
                ->with('error', 'Anda harus mengisi formulir pendaftaran terlebih dahulu.');
        }
        
        // Get transaksi if exists
        $transaksi = Transaksi::where('pendaftar_id', $pendaftar->id)->first();
        
        // Get biaya pendaftaran from prodi
        $biaya = $pendaftar->prodi->biaya ?? 0;
        
        // Generate QR Code jika belum ada transaksi
        $qrCodeUrl = null;
        if (!$transaksi && $biaya > 0) {
            try {
                $qrCodeUrl = $this->generateQRCode($pendaftar, $biaya);
            } catch (\Exception $e) {
                // Jika gagal generate QR, tetap lanjutkan tanpa QR
                $qrCodeUrl = null;
            }
        }
        
        return view('user.pembayaran.index', compact('pendaftar', 'transaksi', 'biaya', 'qrCodeUrl'));
    }
    
    // Method untuk generate QR Code
    private function generateQRCode($pendaftar, $biaya)
    {
        $orderId = 'PMB-' . $pendaftar->id . '-' . time();
        
        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) $biaya,
            ],
            'customer_details' => [
                'first_name' => $pendaftar->name,
                'email' => $pendaftar->email,
                'phone' => $pendaftar->phone,
            ],
            'item_details' => [
                [
                    'id' => 'PMB-' . $pendaftar->prodi_id,
                    'price' => (int) $biaya,
                    'quantity' => 1,
                    'name' => 'Biaya Pendaftaran - ' . ($pendaftar->prodi->nama ?? 'Program Studi'),
                ]
            ],
        ];
        
        $snapToken = Snap::getSnapToken($params);
        return $snapToken;
    }
    
    public function store(Request $request)
    {
        $user = Auth::user();
        $pendaftar = Pendaftar::where('user_id', $user->id)->firstOrFail();
        
        // UPDATE VALIDASI - Tambahkan QR Code sebagai metode pembayaran
        $validatedData = $request->validate([
            'metode_pembayaran' => 'required|in:Transfer Bank,Cash,QRIS',
            'tanggal_bayar' => 'required|date',
            'bukti_bayar' => 'required_if:metode_pembayaran,Transfer Bank,QR Code|file|mimes:jpeg,png,jpg,pdf|max:5120',
        ]);
        
        // Check if transaction already exists
        $transaksi = Transaksi::where('pendaftar_id', $pendaftar->id)->first();
        if ($transaksi) {
            return redirect()->back()->with('error', 'Anda sudah melakukan konfirmasi pembayaran.');
        }
        
        // Generate transaction number
        $nomorTransaksi = 'TRX-' . date('Ymd') . '-' . str_pad($pendaftar->id, 4, '0', STR_PAD_LEFT);
        
        // Create new transaction
        $transaksi = new Transaksi();
        $transaksi->pendaftar_id = $pendaftar->id;
        $transaksi->nomor_transaksi = $nomorTransaksi;
        $transaksi->jumlah = $pendaftar->prodi->biaya ?? 0;
        $transaksi->tanggal_bayar = $validatedData['tanggal_bayar'];
        $transaksi->metode_pembayaran = $validatedData['metode_pembayaran'];
        $transaksi->status = 'pending'; // Default status
        
        // UPDATE - Store bukti bayar untuk Transfer Bank dan QR Code
        if ($request->hasFile('bukti_bayar') && in_array($validatedData['metode_pembayaran'], ['Transfer Bank', 'QRIS'])) {
            // Pastikan folder bukti_bayar ada
            if (!Storage::disk('public')->exists('bukti_bayar')) {
                Storage::disk('public')->makeDirectory('bukti_bayar');
            }
            
            // Gunakan nama file yang unik dengan timestamp
            $fileName = time() . '_' . $request->file('bukti_bayar')->getClientOriginalName();
            
            // Upload file ke storage
            $buktiPath = $request->file('bukti_bayar')->storeAs('bukti_bayar', $fileName, 'public');
            
            // Pastikan file berhasil terupload
            if (!$buktiPath) {
                return redirect()->back()->with('error', 'Gagal mengupload bukti pembayaran. Silakan coba lagi.');
            }
            
            $transaksi->bukti_bayar_url = $buktiPath;
        }
        
        // Simpan transaksi
        try {
            $transaksi->save();
        } catch (\Exception $e) {
            // Hapus file jika gagal menyimpan data
            if (isset($buktiPath) && Storage::disk('public')->exists($buktiPath)) {
                Storage::disk('public')->delete($buktiPath);
            }
            
            return redirect()->back()->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage());
        }
        
        return redirect()->route('user.pembayaran.index')
            ->with('success', 'Konfirmasi pembayaran berhasil disimpan. Mohon tunggu verifikasi dari admin.');
    }
}