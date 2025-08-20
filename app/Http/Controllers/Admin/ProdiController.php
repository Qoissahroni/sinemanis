<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Prodi;

class ProdiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prodis = Prodi::withCount('pendaftar')->orderBy('nama')->paginate(10);
        return view('admin.prodi.index', compact('prodis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.prodi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100|unique:prodis',
            'kode' => 'required|string|max:20|unique:prodis',
            'jenjang' => 'required|string|in:D3,D4,S1,S2,S3',
            'deskripsi' => 'nullable|string',
            'kuota' => 'required|integer|min:1',
            'biaya' => 'required|numeric|min:0',
            'akreditasi' => 'required|string|in:A,B,C,Belum Terakreditasi',
        ]);
        
        Prodi::create($request->all());
        
        return redirect()->route('admin.prodi.index')
            ->with('success', 'Program studi berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $prodi = Prodi::findOrFail($id);
        return view('admin.prodi.edit', compact('prodi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $prodi = Prodi::findOrFail($id);
        
        $request->validate([
            'nama' => 'required|string|max:100|unique:prodis,nama,' . $id,
            'kode' => 'required|string|max:20|unique:prodis,kode,' . $id,
            'jenjang' => 'required|string|in:D3,D4,S1,S2,S3',
            'deskripsi' => 'nullable|string',
            'kuota' => 'required|integer|min:1',
            'biaya' => 'required|numeric|min:0',
            'akreditasi' => 'required|string|in:A,B,C,Belum Terakreditasi',
        ]);
        
        $prodi->update($request->all());
        
        return redirect()->route('admin.prodi.index')
            ->with('success', 'Program studi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $prodi = Prodi::findOrFail($id);
        
        // Cek apakah ada pendaftar yang terkait dengan prodi ini
        if ($prodi->pendaftar()->count() > 0) {
            return redirect()->route('admin.prodi.index')
                ->with('error', 'Program studi tidak dapat dihapus karena masih memiliki pendaftar terkait.');
        }
        
        $prodi->delete();
        
        return redirect()->route('admin.prodi.index')
            ->with('success', 'Program studi berhasil dihapus.');
    }
}