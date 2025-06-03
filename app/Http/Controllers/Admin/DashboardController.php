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
        // DATA UNTUK OVERVIEW CARDS

        $totalReports = Report::count();
        $newUsersThisMonth = User::where('created_at', '>=', Carbon::now()->startOfMonth())->count();
        $visits = 3671; // Placeholder
        $activeUsers = 2318; // Placeholder

        // DATA UNTUK GRAFIK LAPORAN PER BULAN

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

        // DATA UNTUK STATUS LAPORAN (FIXED)

        $reportStatusCounts = Report::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status'); // Ini akan menghasilkan Collection

        // (Opsional tapi direkomendasikan) Pastikan semua status yang didefinisikan ada, meskipun jumlahnya 0
        $definedStatusesForController = ['unread', 'review', 'ongoing', 'solved', 'denied', 'archived'];
        foreach ($definedStatusesForController as $status) {
            if (!$reportStatusCounts->has($status)) {
                // Jika $reportStatusCounts adalah instance dari Illuminate\Support\Collection
                $reportStatusCounts->put($status, 0);
                // Jika $reportStatusCounts adalah array biasa, gunakan:
                // $reportStatusCounts[$status] = 0;
            }
        }
        // Pastikan $reportStatusCounts adalah Collection jika Anda menggunakan ->put()
        // Jika pluck() sudah mengembalikan Collection (default di Laravel), ini sudah benar.


        // =====================================================
        // DATA UNTUK PIE CHART (REPORTER & PERPETRATOR)
        // =====================================================
        $reporterByRoles = Report::select('reporter_role', DB::raw('count(*) as total'))
            ->groupBy('reporter_role')
            ->pluck('total', 'reporter_role');

        $perpetratorByRoles = Report::select('perpetrator_role', DB::raw('count(*) as total'))
            ->whereNotNull('perpetrator_role') // Hanya hitung jika perpetrator_role tidak null
            ->groupBy('perpetrator_role')
            ->pluck('total', 'perpetrator_role');

        $totalReporters = $reporterByRoles->sum();
        $totalPerpetrators = $perpetratorByRoles->sum();

        // =====================================================
        // MENGIRIM SEMUA DATA KE VIEW
        // =====================================================
        return view('admin.dashboard', [ // Ganti 'admin.dashboard' dengan path view Anda yang benar
            'totalReports' => $totalReports,
            'newUsersThisMonth' => $newUsersThisMonth,
            'visits' => $visits,
            'activeUsers' => $activeUsers,
            'reportChartData' => array_values($reportChartData), // Untuk chart.js biasanya butuh array values
            'reportStatusCounts' => $reportStatusCounts,
            'reporterByRoles' => $reporterByRoles,
            'perpetratorByRoles' => $perpetratorByRoles,
            'totalReporters' => $totalReporters,
            'totalPerpetrators' => $totalPerpetrators,
        ]);
    }
}
