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

class PembayaranSelisihController extends Controller
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

        if (!$pendaftar || $pendaftar->status_ganti_prodi !== 'approved' || $pendaftar->selisih_biaya_prodi <= 0) {
            return redirect()->route('user.formulir.index')->with('error', 'Tidak ada pembayaran selisih yang perlu dilakukan.');
        }

        $transaksi = Transaksi::where('pendaftar_id', $pendaftar->id)
            ->where('keterangan', 'Pembayaran selisih biaya pergantian prodi')
            ->first();

        if (!$transaksi) {
            return redirect()->route('user.formulir.index')->with('error', 'Transaksi selisih tidak ditemukan.');
        }

        $biaya = $transaksi->jumlah;

        // Generate QR Code if belum ada detail pembayaran
        $qrCodeUrl = null;
        if (!$transaksi->metode_pembayaran && $biaya > 0) {
            try {
                $qrCodeUrl = $this->generateQRCode($pendaftar, $biaya);
            } catch (\Exception $e) {
                $qrCodeUrl = null;
            }
        }

        return view('user.pembayaran.selisih', compact('pendaftar', 'transaksi', 'biaya', 'qrCodeUrl'));
    }

    private function generateQRCode($pendaftar, $biaya)
    {
        $orderId = 'SELISIH-' . $pendaftar->id . '-' . time();

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
                    'id' => 'SELISIH-' . $pendaftar->id,
                    'price' => (int) $biaya,
                    'quantity' => 1,
                    'name' => 'Selisih Biaya Prodi',
                ]
            ],
        ];

        return Snap::getSnapToken($params);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $pendaftar = Pendaftar::where('user_id', $user->id)->firstOrFail();

        $validatedData = $request->validate([
            'metode_pembayaran' => 'required|in:Transfer Bank,Cash,QRIS',
            'tanggal_bayar' => 'required|date',
            'bukti_bayar' => 'required_if:metode_pembayaran,Transfer Bank,QRIS|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        $transaksi = Transaksi::where('pendaftar_id', $pendaftar->id)
            ->where('keterangan', 'Pembayaran selisih biaya pergantian prodi')
            ->firstOrFail();

        if ($transaksi->metode_pembayaran) {
            return redirect()->back()->with('error', 'Anda sudah melakukan konfirmasi pembayaran selisih.');
        }

        $transaksi->tanggal_bayar = $validatedData['tanggal_bayar'];
        $transaksi->metode_pembayaran = $validatedData['metode_pembayaran'];
        $transaksi->status = 'pending';

        if ($request->hasFile('bukti_bayar') && in_array($validatedData['metode_pembayaran'], ['Transfer Bank', 'QRIS'])) {
            if (!Storage::disk('public')->exists('bukti_bayar')) {
                Storage::disk('public')->makeDirectory('bukti_bayar');
            }
            $fileName = time() . '_' . $request->file('bukti_bayar')->getClientOriginalName();
            $buktiPath = $request->file('bukti_bayar')->storeAs('bukti_bayar', $fileName, 'public');
            if (!$buktiPath) {
                return redirect()->back()->with('error', 'Gagal mengupload bukti pembayaran.');
            }
            $transaksi->bukti_bayar_url = $buktiPath;
        }

        $transaksi->save();

        return redirect()->route('user.pembayaran-selisih.index')
            ->with('success', 'Konfirmasi pembayaran selisih berhasil disimpan. Mohon tunggu verifikasi dari admin.');
    }
}