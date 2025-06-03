<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report; // Pastikan model Report sudah di-import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function index()
    {
        // 1. Data Laporan per Bulan (sudah ada)
        $reportsByMonth = Report::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as count')
        )
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->all();

        $monthlyReportData = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyReportData[$i] = $reportsByMonth[$i] ?? 0;
        }

        // 2. Data Laporan berdasarkan Role Pelapor
        $reporterByRolesData = Report::select('reporter_role', DB::raw('count(*) as total'))
            ->groupBy('reporter_role')
            ->pluck('total', 'reporter_role');

        // 3. Data Laporan berdasarkan Role Terlapor
        $perpetratorByRolesData = Report::select('perpetrator_role', DB::raw('count(*) as total'))
            ->whereNotNull('perpetrator_role') // Hanya ambil yang role terlapornya terisi
            ->groupBy('perpetrator_role')
            ->pluck('total', 'perpetrator_role');

        return view('admin.charts', [
            'monthlyReportData' => array_values($monthlyReportData), // Data untuk laporan per bulan
            'reporterByRolesData' => $reporterByRolesData,         // Data untuk pelapor berdasarkan role
            'perpetratorByRolesData' => $perpetratorByRolesData,   // Data untuk terlapor berdasarkan role
        ]);
    }
}
