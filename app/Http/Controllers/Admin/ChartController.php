<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Report;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function index()
    {
        // Mengambil data laporan per bulan untuk tahun ini
        $reportsByMonth = Report::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as count')
            )
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->all();

        // Memastikan semua 12 bulan ada datanya (meskipun 0)
        $reportChartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $reportChartData[$i] = $reportsByMonth[$i] ?? 0;
        }

        // Kirim data ke view baru kita
        return view('admin.charts', [
            'reportChartData' => array_values($reportChartData),
        ]);
    }
}
