<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pendaftar;
use App\Models\Prodi;
use App\Models\Transaksi;
use Carbon\Carbon;

class LaporanController extends Controller
{
    /**
     * Display the main report page with program statistics
     */
    public function index(Request $request)
    {
        // Get all prodis for filter dropdown
        $allProdis = Prodi::orderBy('nama')->get();
        
        // Calculate overall statistics for current filter
        $statistikQuery = Pendaftar::query();
        
        if ($request->filled('prodi_id')) {
            $statistikQuery->where('prodi_id', $request->prodi_id);
        }
        
        if ($request->filled('status')) {
            $statistikQuery->where('status', $request->status);
        }
        
        $statistik = [
            'total' => $statistikQuery->count(),
            'pending' => (clone $statistikQuery)->where('status', 'pending')->count(),
            'verified' => (clone $statistikQuery)->where('status', 'verified')->count(),
            'accepted' => (clone $statistikQuery)->where('status', 'accepted')->count(),
            'rejected' => (clone $statistikQuery)->where('status', 'rejected')->count(),
        ];
        
        // Get statistics per program studi
        $prodiStatsQuery = Prodi::query();
        
        // If filtering by specific prodi, only get that prodi
        if ($request->filled('prodi_id')) {
            $prodiStatsQuery->where('id', $request->prodi_id);
        }
        
        $prodiStats = $prodiStatsQuery->withCount([
            'pendaftar as total_pendaftar' => function ($query) use ($request) {
                if ($request->filled('status')) {
                    $query->where('status', $request->status);
                }
            },
            'pendaftar as pending_count' => function ($query) use ($request) {
                $query->where('status', 'pending');
                if ($request->filled('status') && $request->status != 'pending') {
                    $query->where('id', 0); // Return 0 if filtering by different status
                }
            },
            'pendaftar as verified_count' => function ($query) use ($request) {
                $query->where('status', 'verified');
                if ($request->filled('status') && $request->status != 'verified') {
                    $query->where('id', 0);
                }
            },
            'pendaftar as accepted_count' => function ($query) use ($request) {
                $query->where('status', 'accepted');
                if ($request->filled('status') && $request->status != 'accepted') {
                    $query->where('id', 0);
                }
            },
            'pendaftar as rejected_count' => function ($query) use ($request) {
                $query->where('status', 'rejected');
                if ($request->filled('status') && $request->status != 'rejected') {
                    $query->where('id', 0);
                }
            }
        ])->orderBy('nama')->get();
        
        return view('admin.laporan.index', compact(
            'allProdis',
            'statistik',
            'prodiStats'
        ));
    }
    
    /**
     * Display detail pendaftar for specific prodi
     */
    public function detailProdi(Request $request, $prodiId)
    {
        // Find prodi or fail
        $prodi = Prodi::findOrFail($prodiId);
        
        // Build query untuk pendaftar
        $query = Pendaftar::where('prodi_id', $prodiId);
        
        // Apply status filter if provided
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Get pendaftar data
        $pendaftars = $query->orderBy('created_at', 'desc')->get();
        
        // Calculate statistics for this prodi
        $statistik = [
            'total' => $pendaftars->count(),
            'pending' => $pendaftars->where('status', 'pending')->count(),
            'verified' => $pendaftars->where('status', 'verified')->count(),
            'accepted' => $pendaftars->where('status', 'accepted')->count(),
            'rejected' => $pendaftars->where('status', 'rejected')->count(),
        ];
        
        return view('admin.laporan.detail-prodi', compact(
            'prodi',
            'pendaftars', 
            'statistik'
        ));
    }
    

    
    /**
     * Generate report of registrants by period.
     */
    public function pendaftarPeriode(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);
        
        $startDate = Carbon::parse($request->start_date)->startOfDay();
        $endDate = Carbon::parse($request->end_date)->endOfDay();
        
        // Data pendaftar berdasarkan periode
        $pendaftars = Pendaftar::whereBetween('created_at', [$startDate, $endDate])
                        ->with('prodi')
                        ->orderBy('created_at', 'desc')
                        ->get();
        
        // Statistik status pendaftar
        $totalPendaftar = $pendaftars->count();
        $pendingCount = $pendaftars->where('status', 'pending')->count();
        $verifiedCount = $pendaftars->where('status', 'verified')->count();
        $acceptedCount = $pendaftars->where('status', 'accepted')->count();
        $rejectedCount = $pendaftars->where('status', 'rejected')->count();
        
        // Data untuk chart (pendaftar per hari)
        $chartData = [];
        $currentDate = clone $startDate;
        
        while ($currentDate <= $endDate) {
            $date = $currentDate->format('Y-m-d');
            $count = $pendaftars->filter(function ($item) use ($currentDate) {
                return $item->created_at->format('Y-m-d') === $currentDate->format('Y-m-d');
            })->count();
            
            $chartData[] = [
                'tanggal' => $currentDate->format('d M Y'),
                'jumlah' => $count
            ];
            
            $currentDate->addDay();
        }
        
        return view('admin.laporan.pendaftar-periode', compact(
            'pendaftars',
            'startDate',
            'endDate',
            'totalPendaftar',
            'pendingCount',
            'verifiedCount',
            'acceptedCount',
            'rejectedCount',
            'chartData'
        ));
    }
}