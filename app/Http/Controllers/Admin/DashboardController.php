<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // =====================================================
        // DATA UNTUK OVERVIEW CARDS (TIDAK BERUBAH)
        // =====================================================
        $totalReports = Report::count();
        $newUsersThisMonth = User::where('created_at', '>=', Carbon::now()->startOfMonth())->count();
        $visits = 3671; // Placeholder
        $activeUsers = 2318; // Placeholder

        // =====================================================
        // DATA UNTUK GRAFIK LAPORAN PER BULAN (TIDAK BERUBAH)
        // =====================================================
        $reportsByMonth = Report::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as count')
        )
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->all();

        $reportChartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $reportChartData[$i] = $reportsByMonth[$i] ?? 0;
        }


        // =====================================================
        // DATA UNTUK STATUS LAPORAN (DINONAKTIFKAN SEMENTARA)
        // =====================================================
        // Catatan: Kode ini baru bisa dijalankan setelah Anda menambahkan kolom 'status' ke tabel 'report'.
        $reportStatusCounts = Report::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $reportStatusCounts = collect(); // Berikan nilai koleksi kosong untuk sementara


        // =====================================================
        // DATA UNTUK PIE CHART (REPORTER & PERPETRATOR)
        // =====================================================

        // === PERUBAHAN DI SINI ===
        // Query disederhanakan karena 'reporter_role' ada di tabel 'report'. Tidak perlu JOIN.
        $reporterByRoles = Report::select('reporter_role', DB::raw('count(*) as total'))
            ->groupBy('reporter_role')
            ->pluck('total', 'reporter_role');

        $perpetratorByRoles = Report::select('perpetrator_role', DB::raw('count(*) as total'))
            ->whereNotNull('perpetrator_role')
            ->groupBy('perpetrator_role')
            ->pluck('total', 'perpetrator_role');

        $totalReporters = $reporterByRoles->sum();
        $totalPerpetrators = $perpetratorByRoles->sum();

        // =====================================================
        // MENGIRIM SEMUA DATA KE VIEW
        // =====================================================
        return view('admin.dashboard', [
            'totalReports' => $totalReports,
            'newUsersThisMonth' => $newUsersThisMonth,
            'visits' => $visits,
            'activeUsers' => $activeUsers,
            'reportChartData' => array_values($reportChartData),
            'reportStatusCounts' => $reportStatusCounts,
            'reporterByRoles' => $reporterByRoles,
            'perpetratorByRoles' => $perpetratorByRoles,
            'totalReporters' => $totalReporters,       // <-- Kirim data total ini
            'totalPerpetrators' => $totalPerpetrators,
        ]);
    }
}
