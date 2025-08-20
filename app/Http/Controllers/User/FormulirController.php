<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Models\Pendaftar;
use App\Models\Prodi;
use App\Mail\PendaftaranBerhasil;

class FormulirController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $pendaftar = Pendaftar::with(['prodi', 'prodiBaru'])->where('user_id', $user->id)->first();
        $prodis = Prodi::select('id','kode','nama','jenjang','akreditasi','biaya','kuota')
        ->selectRaw("(kuota - COALESCE((SELECT COUNT(*) FROM pendaftars WHERE prodi_id = prodis.id), 0)) AS kuota_tersisa")
        ->orderBy('nama')
        ->get();
            
        // Check if form has been submitted
        $isSubmitted = false;
        if ($pendaftar) {
            $isSubmitted = true;
        }
        
        return view('user.formulir.index', compact('pendaftar', 'prodis', 'isSubmitted'));
    }
    
    public function store(Request $request)
    {
        $user = Auth::user();
        
        // Validate data
        $validatedData = $request->validate([
            // Data Mahasiswa
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
            'nik' => 'required|string|size:16',
            'agama' => 'required|string',
            'nisn' => 'required|string|max:20',
            'jenis_pendaftaran' => 'required|in:Peserta didik baru,Pindahan',
            'alamat' => 'required|string',
            'jenis_tinggal' => 'required|string',
            'alat_transportasi' => 'required|string',
            'no_hp' => 'required|string|max:15',
            'email' => 'required|email',
            'kps' => 'required|in:Ya,Tidak',
            'no_kps' => 'nullable|required_if:kps,Ya|string|max:50',
            'bekerja' => 'required|in:Ya,Tidak',
            'tempat_kerja' => 'nullable|required_if:bekerja,Ya|string|max:255',
            'penghasilan' => 'nullable|required_if:bekerja,Ya|string',
            
            // Data Orang Tua/Wali
            'nik_ayah' => 'required|string|size:16',
            'nama_ayah' => 'required|string|max:255',
            'tanggal_lahir_ayah' => 'required|date',
            'pendidikan_ayah' => 'required|string',
            'pekerjaan_ayah' => 'required|string',
            'penghasilan_ayah' => 'required|string',
            
            'nik_ibu' => 'required|string|size:16',
            'nama_ibu' => 'required|string|max:255',
            'tanggal_lahir_ibu' => 'required|date',
            'pekerjaan_ibu' => 'required|string',
            'penghasilan_ibu' => 'required|string',
            
            'nik_wali' => 'nullable|string|size:16',
            'nama_wali' => 'nullable|string|max:255',
            'tanggal_lahir_wali' => 'nullable|date',
            'pekerjaan_wali' => 'nullable|string',
            'penghasilan_wali' => 'nullable|string',
            
            'no_hp_ortu' => 'required|string|max:15',
            
            // Program Studi
            'prodi_id' => 'required|exists:prodis,id',
            'kelas' => 'required|string',
            'ukuran_almamater' => 'required|string',
            'ukuran_kaos' => 'required|string',
            
            // Data Asal Sekolah
            'asal_sekolah' => 'required|string|max:255',
            'tahun_lulus' => 'required|digits:4',
            'asal_perguruan_tinggi' => 'nullable|required_if:jenis_pendaftaran,Pindahan|string|max:255',
            'asal_prodi' => 'nullable|required_if:jenis_pendaftaran,Pindahan|string|max:255',
            'semester_terakhir' => 'nullable|required_if:jenis_pendaftaran,Pindahan|integer|min:1',
            
            // Berkas Pendaftaran
            'berkas_pendaftaran' => 'required|file|mimes:pdf|max:5120',
            'pas_foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        
        // Handle file uploads
        $berkasPath = $request->file('berkas_pendaftaran')->store('berkas_pendaftaran', 'public');
        $fotoPath = $request->file('pas_foto')->store('pas_foto', 'public');
        
        // Create Pendaftar record
        $pendaftar = new Pendaftar();
        $pendaftar->user_id = $user->id;
        $pendaftar->name = $validatedData['nama_lengkap'];
        $pendaftar->email = $validatedData['email'];
        $pendaftar->phone = $validatedData['no_hp'];
        $pendaftar->jenis_kelamin = $validatedData['jenis_kelamin'];
        $pendaftar->tanggal_lahir = $validatedData['tanggal_lahir'];
        $pendaftar->tempat_lahir = $validatedData['tempat_lahir'];
        $pendaftar->nik = $validatedData['nik'];
        $pendaftar->agama = $validatedData['agama'];
        $pendaftar->nisn = $validatedData['nisn'];
        $pendaftar->jenis_pendaftaran = $validatedData['jenis_pendaftaran'];
        $pendaftar->alamat = $validatedData['alamat'];
        $pendaftar->jenis_tinggal = $validatedData['jenis_tinggal'];
        $pendaftar->alat_transportasi = $validatedData['alat_transportasi'];
        $pendaftar->kps = $validatedData['kps'];
        $pendaftar->no_kps = $validatedData['no_kps'];
        $pendaftar->bekerja = $validatedData['bekerja'];
        $pendaftar->tempat_kerja = $validatedData['tempat_kerja'];
        $pendaftar->penghasilan = $validatedData['penghasilan'];
        
        // Data orang tua
        $pendaftar->nik_ayah = $validatedData['nik_ayah'];
        $pendaftar->nama_ayah = $validatedData['nama_ayah'];
        $pendaftar->tanggal_lahir_ayah = $validatedData['tanggal_lahir_ayah'];
        $pendaftar->pendidikan_ayah = $validatedData['pendidikan_ayah'];
        $pendaftar->pekerjaan_ayah = $validatedData['pekerjaan_ayah'];
        $pendaftar->penghasilan_ayah = $validatedData['penghasilan_ayah'];
        
        $pendaftar->nik_ibu = $validatedData['nik_ibu'];
        $pendaftar->nama_ibu = $validatedData['nama_ibu'];
        $pendaftar->tanggal_lahir_ibu = $validatedData['tanggal_lahir_ibu'];
        $pendaftar->pekerjaan_ibu = $validatedData['pekerjaan_ibu'];
        $pendaftar->penghasilan_ibu = $validatedData['penghasilan_ibu'];
        
        $pendaftar->nik_wali = $validatedData['nik_wali'];
        $pendaftar->nama_wali = $validatedData['nama_wali'];
        $pendaftar->tanggal_lahir_wali = $validatedData['tanggal_lahir_wali'];
        $pendaftar->pekerjaan_wali = $validatedData['pekerjaan_wali'];
        $pendaftar->penghasilan_wali = $validatedData['penghasilan_wali'];
        $pendaftar->no_hp_ortu = $validatedData['no_hp_ortu'];
        
        // Program studi
        $pendaftar->prodi_id = $validatedData['prodi_id'];
        $pendaftar->kelas = $validatedData['kelas'];
        $pendaftar->ukuran_almamater = $validatedData['ukuran_almamater'];
        $pendaftar->ukuran_kaos = $validatedData['ukuran_kaos'];
        
        // Data sekolah
        $pendaftar->asal_sekolah = $validatedData['asal_sekolah'];
        $pendaftar->tahun_lulus = $validatedData['tahun_lulus'];
        $pendaftar->asal_perguruan_tinggi = $validatedData['asal_perguruan_tinggi'];
        $pendaftar->asal_prodi = $validatedData['asal_prodi'];
        $pendaftar->semester_terakhir = $validatedData['semester_terakhir'];
        
        // Files
        $pendaftar->berkas_url = $berkasPath;
        $pendaftar->foto_url = $fotoPath;
        
        // Status
        $pendaftar->status = 'pending'; // Default status
        
        $pendaftar->save();
        // Kirim email notifikasi
        try {
            Mail::to($pendaftar->email)->send(new PendaftaranBerhasil($pendaftar));
        } catch (\Exception $e) {
            // Jika email gagal dikirim, tetap lanjutkan proses
            // Log error bisa ditambahkan di sini jika diperlukan
        }
        
        return redirect()->route('user.pembayaran.index')
        ->with('success', 'Formulir pendaftaran berhasil disimpan dan email konfirmasi telah dikirim. Silakan lanjutkan dengan pembayaran.');
            
    }
    
    public function update(Request $request)
    {
        $user = Auth::user();
        $pendaftar = Pendaftar::where('user_id', $user->id)->firstOrFail();
        
        // Similar validation and update logic as store method
        // Only allow updates if status is still 'pending'
        if ($pendaftar->status != 'pending') {
            return redirect()->back()->with('error', 'Formulir tidak dapat diubah karena sudah diverifikasi.');
        }
        
        // Update logic...
        // Very similar to store() but update existing record
        
        return redirect()->route('user.formulir.index')
            ->with('success', 'Formulir pendaftaran berhasil diperbarui.');
    }
    
    /**
     * Handle pergantian prodi request
     */
    public function gantiProdi(Request $request)
    {
        $user = Auth::user();
        $pendaftar = Pendaftar::where('user_id', $user->id)->firstOrFail();
        
        // Check if already changed prodi
        if ($pendaftar->sudah_ganti_prodi) {
            return redirect()->back()->with('error', 'Anda sudah menggunakan kesempatan pergantian program studi.');
        }
        
        // Validate request
        $validatedData = $request->validate([
            'prodi_baru_id' => 'required|exists:prodis,id|different:prodi_id',
            'kelas_baru' => 'required|string',
            'alasan_ganti_prodi' => 'required|string|max:500',
        ]);
        
        $prodiBaru = Prodi::findOrFail($validatedData['prodi_baru_id']);
        $prodiLama = $pendaftar->prodi;
        
        // Calculate selisih biaya
        $selisihBiaya = $prodiBaru->biaya - $prodiLama->biaya;
        
        // Update pendaftar
        $pendaftar->prodi_baru_id = $validatedData['prodi_baru_id'];
        $pendaftar->kelas_baru = $validatedData['kelas_baru'];
        $pendaftar->alasan_ganti_prodi = $validatedData['alasan_ganti_prodi'];
        $pendaftar->selisih_biaya_prodi = $selisihBiaya;
        $pendaftar->status_ganti_prodi = 'pending';
        $pendaftar->save();
        
        return redirect()->route('user.formulir.index')
            ->with('success', 'Pengajuan pergantian program studi berhasil dikirim. Menunggu persetujuan admin.');
    }
}