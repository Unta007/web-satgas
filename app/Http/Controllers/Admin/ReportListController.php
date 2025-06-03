<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Report;
use Illuminate\Support\Facades\Storage;


class ReportListController extends Controller
{
    /**
     * Menampilkan daftar laporan yang belum dibaca untuk admin.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function unread(Request $request)
    {
        $reports = Report::where('status', 'unread')
            ->with('user')
            ->latest()
            ->get();

        return view('admin.reports.unread', [
            'reports' => $reports,
        ]);
    }

    public function review()
    {
        $reports = Report::where('status', 'review')
            ->with('user')
            ->latest()
            ->get();

        return view('admin.reports.review', [
            'reports' => $reports,
        ]);
    }

    public function ongoing()
    {
        $reports = Report::where('status', 'ongoing')
            ->with('user')
            ->latest()
            ->get();

        return view('admin.reports.ongoing', [
            'reports' => $reports,
        ]);
    }

    public function solved()
    {
        $reports = Report::where('status', 'solved')
            ->with('user')
            ->latest()
            ->get();

        return view('admin.reports.solved', [
            'reports' => $reports,
        ]);
    }

    public function denied()
    {
        $reports = Report::where('status', 'denied')
            ->with('user')
            ->latest()
            ->get();

        return view('admin.reports.denied', [
            'reports' => $reports,
        ]);
    }

    /**
     * Menampilkan form untuk mengedit status laporan.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\View\View
     */
    public function edit(Report $report)
    {
        // Ambil juga data user pelapor
        $report->load('user');

        // Status yang bisa dipilih oleh admin
        $availableStatuses = ['unread', 'review', 'ongoing', 'solved', 'denied', 'archived'];

        return view('admin.reports.edit', [
            'report' => $report,
            'availableStatuses' => $availableStatuses
        ]);
    }

    public function downloadEvidence(Report $report)
    {
        // Pastikan laporan memiliki file bukti dan file tersebut ada di storage
        if (!$report->evidence_path || !Storage::disk('local')->exists($report->evidence_path)) {
            // Anda bisa mengganti 'local' dengan disk yang Anda gunakan untuk menyimpan 'evidence_uploads'
            // seperti yang Anda definisikan di ReportController@store: $file->storeAs('evidence_uploads', $filename, 'local');

            // Jika file tidak ditemukan, kembalikan ke halaman sebelumnya dengan pesan error
            return back()->with('error', 'File bukti tidak ditemukan.');
        }

        // Dapatkan path lengkap ke file
        $filePath = Storage::disk('local')->path($report->evidence_path);

        // Dapatkan nama file asli untuk di-download
        // Jika Anda menyimpan nama file asli di database, gunakan itu.
        // Jika tidak, kita bisa menggunakan basename dari path.
        $fileName = basename($report->evidence_path);

        // Header untuk memaksa unduhan
        $headers = [
            'Content-Type' => Storage::disk('local')->mimeType($report->evidence_path),
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        return Storage::disk('local')->download($report->evidence_path, $fileName, $headers);
    }

    /**
     * Memperbarui status laporan.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(Request $request, Report $report)
    {
        $availableStatuses = ['unread', 'review', 'ongoing', 'solved', 'denied', 'archived'];

        $request->validate([
            'status' => ['required', Rule::in($availableStatuses)],
        ]);

        $report->status = $request->status;
        $report->save();

        // Arahkan kembali ke halaman daftar laporan 'unread' atau halaman detail laporan
        return redirect()->route('admin.reports.unread')
            ->with('success', 'Status laporan #' . $report->id . ' berhasil diperbarui menjadi "' . ucfirst($request->status) . '".');
    }

    public function destroy(Report $report)
    {
        $reportId = $report->id; // Simpan ID sebelum dihapus
        $report->delete();

        // Pesan sukses untuk delete
        return redirect()->route('admin.reports.unread')
            ->with('success', 'Laporan #' . $reportId . ' berhasil dihapus.');
    }
}
