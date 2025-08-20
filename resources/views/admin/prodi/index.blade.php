@extends('admin.layouts.app')

@section('title', 'Program Studi')

@section('page-title', 'Program Studi')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Daftar Program Studi</h5>
            <a href="{{ route('admin.prodi.create') }}" class="btn btn-primary-custom">
                <i class="fas fa-plus-circle me-1"></i> Tambah Program Studi
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama Program Studi</th>
                            <th>Jenjang</th>
                            <th>Akreditasi</th> 
                            <th>Kuota</th>
                            <th>Biaya (Rp)</th>
                            <th>Pendaftar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($prodis as $index => $prodi)
                            <tr>
                                <td>{{ $index + $prodis->firstItem() }}</td>
                                <td>{{ $prodi->kode }}</td>
                                <td>{{ $prodi->nama }}</td>
                                <td>{{ $prodi->jenjang }}</td>
                                <td>{{ $prodi->akreditasi }}</td>
                                <td>{{ $prodi->kuota }}</td>
                                <td>{{ number_format($prodi->biaya, 0, ',', '.') }}</td>
                                <td>{{ $prodi->pendaftar_count }}</td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('admin.prodi.edit', $prodi->id) }}" class="btn btn-sm btn-warning me-1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.prodi.destroy', $prodi->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus program studi ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">Tidak ada data program studi</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination (Simple) - Tanpa tombol Sebelumnya/Selanjutnya -->
            <div class="d-flex justify-content-center mt-4">
                {{ $prodis->appends(request()->query())->links('pagination::simple-bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection