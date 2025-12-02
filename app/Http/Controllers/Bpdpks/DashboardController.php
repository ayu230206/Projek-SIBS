<?php

namespace App\Http\Controllers\Bpdpks;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\MahasiswaDetail; 
use App\Models\Bpdpks\Kampus; // Sesuai dengan relasi di MahasiswaDetail
use App\Models\Bpdpks\LowonganAplikasi; // Untuk Pending Approvals
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Total Recipients (Mahasiswa dengan role 'mahasiswa')
        $totalRecipients = User::where('role', 'mahasiswa')->count();

        // 2. Active Campuses (Kampus unik yang memiliki data mahasiswa)
        $activeKampusIds = MahasiswaDetail::select('kampus_id')
                            ->distinct()
                            ->pluck('kampus_id');

        $activeCampuses = $activeKampusIds->count();
                            
        // 3. Pending Approvals (Lowongan Aplikasi dengan status 'diajukan')
        $pendingApprovals = LowonganAplikasi::where('status', 'diajukan')->count();

        // 4. Data IPK Rata-Rata per Kampus (untuk Bar Chart)
        $ipkByCampus = MahasiswaDetail::select(
                                'kampus_id', 
                                DB::raw('ROUND(AVG(ipk), 2) as avg_ipk')
                            )
                            ->groupBy('kampus_id')
                            ->with('kampus:id,kode_kampus') // Ambil kode kampus untuk label chart
                            ->get()
                            ->map(function ($item) {
                                // Menggunakan kode_kampus sebagai label
                                $label = $item->kampus ? ($item->kampus->kode_kampus ?? 'Kampus #' . $item->kampus_id) : 'Unknown';
                                return [
                                    'label' => $label,
                                    'ipk' => (float) $item->avg_ipk
                                ];
                            });

        // 5. Data Distribusi IPK (untuk Donut Chart)
        $totalMhs = MahasiswaDetail::count();
        $excellent = MahasiswaDetail::where('ipk', '>=', 3.80)->count();
        $good = MahasiswaDetail::whereBetween('ipk', [3.50, 3.79])->count();
        $needsAttention = MahasiswaDetail::where('ipk', '<', 3.50)->count();

        $ipkDistribution = [
            // Data dikirim dalam bentuk count, persentase dihitung di View (JS)
            'excellent' => $excellent,
            'good' => $good,
            'needsAttention' => $needsAttention,
        ];
        
        // List kampus unik untuk filter dropdown
        // Menggunakan data dari MahasiswaDetail yang sudah dirata-rata
        $campusList = $ipkByCampus->pluck('label')->unique()->values();


        return view('bpdpks.dashboard', compact(
            'totalRecipients', 
            'activeCampuses', 
            'pendingApprovals',
            'ipkByCampus',
            'ipkDistribution',
            'campusList'
        ));
    }
}