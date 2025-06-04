<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Report;
use Illuminate\Support\Facades\Storage;
use App\Notifications\ReportStatusUpdated;


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

    public function archived(Request $request)
    {
        $reports = Report::where('is_archived', true) // Ambil laporan yang diarsipkan
            ->with('user')
            ->latest('updated_at') // Urutkan berdasarkan kapan terakhir diupdate (bisa jadi waktu arsip)
            ->get();

        return view('admin.reports.archived', [
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
        $report->load('user');
        $availableStatuses = ['unread', 'review', 'ongoing', 'solved', 'denied', 'archived'];

        // Tentukan route untuk tombol "Kembali"
        $backRoute = 'admin.reports.unread'; // Default fallback

        if ($report->is_archived) {
            $backRoute = 'admin.reports.archived';
        } else {
            switch ($report->status) {
                case 'unread':
                    $backRoute = 'admin.reports.unread';
                    break;
                case 'review':
                    $backRoute = 'admin.reports.review';
                    break;
                case 'ongoing':
                    $backRoute = 'admin.reports.ongoing';
                    break;
                case 'solved':
                    $backRoute = 'admin.reports.solved';
                    break;
                case 'denied':
                    $backRoute = 'admin.reports.denied';
                    break;
            }
        }

        return view('admin.reports.edit', [
            'report' => $report,
            'availableStatuses' => $availableStatuses,
            'backRouteName' => $backRoute // Kirim nama route ke view
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
        $availableStatusesForLogic = ['unread', 'review', 'ongoing', 'solved', 'denied', 'archived'];

        $request->validate([
            'status' => ['required', Rule::in($availableStatusesForLogic)],
        ]);

        $selectedAction = $request->status;
        $oldStatus = $report->status; // Simpan status lama
        $wasArchived = $report->is_archived;

        $successMessage = '';
        $redirectRouteName = '';

        $statusChangedForUserNotification = false;

        if ($selectedAction == 'archived') {
            if (!$wasArchived) { // Hanya set jika sebelumnya tidak diarsipkan
                $report->is_archived = true;
                $successMessage = 'Laporan #' . $report->id . ' berhasil diarsipkan.';
                // Tidak mengirim notifikasi status jika hanya diarsipkan, kecuali Anda mau
            } else {
                $successMessage = 'Laporan #' . $report->id . ' sudah diarsipkan.';
            }
            $redirectRouteName = 'admin.reports.archived';
        } else {
            // Jika status baru berbeda dengan status lama ATAU jika laporan di-unarchive
            if ($report->status !== $selectedAction || $report->is_archived) {
                $report->status = $selectedAction;
                $statusChangedForUserNotification = true; // Tandai bahwa status berubah untuk notifikasi user
            }
            $report->is_archived = false; // Jika status aktif diubah, pastikan tidak diarsipkan

            if ($statusChangedForUserNotification) {
                $successMessage = 'Status laporan #' . $report->id . ' berhasil diperbarui menjadi "' . ucfirst($selectedAction) . '".';
            } else {
                $successMessage = 'Status laporan #' . $report->id . ' tidak berubah.';
            }

            switch ($selectedAction) {
                case 'unread':
                    $redirectRouteName = 'admin.reports.unread';
                    break;
                case 'review':
                    $redirectRouteName = 'admin.reports.review';
                    break;
                case 'ongoing':
                    $redirectRouteName = 'admin.reports.ongoing';
                    break;
                case 'solved':
                    $redirectRouteName = 'admin.reports.solved';
                    break;
                case 'denied':
                    $redirectRouteName = 'admin.reports.denied';
                    break;
                default:
                    $redirectRouteName = 'admin.reports.unread';
            }
        }

        $report->save();

        // Kirim notifikasi ke pengguna jika statusnya berubah (dan bukan hanya pengarsipan)
        // Pastikan $report->user adalah instance User yang membuat laporan
        if ($statusChangedForUserNotification && $report->user && $selectedAction !== 'archived') {
            // Pastikan user yang membuat laporan ada dan bisa menerima notifikasi
            // Anda mungkin perlu memuat relasi user jika belum: $report->load('user');
            $reportOwner = $report->user; // Asumsi relasi 'user' ada di model Report
            if ($reportOwner) {
                try {
                    $reportOwner->notify(new ReportStatusUpdated($report, $selectedAction, $oldStatus));
                } catch (\Exception $e) {
                    // Tangani error pengiriman notifikasi jika perlu, misal log error
                    \Log::error("Gagal mengirim notifikasi untuk laporan #{$report->id}: " . $e->getMessage());
                }
            }
        }

        if ($redirectRouteName) {
            return redirect()->route($redirectRouteName)->with('success', $successMessage);
        }
        return redirect()->back()->with('success', $successMessage);
    }

    /**
     * Menghapus laporan secara permanen.
     */
    public function destroy(Report $report)
    {
        $reportId = $report->id;
        // Hapus file bukti jika ada sebelum menghapus record laporan
        if ($report->evidence_path && Storage::disk('local')->exists($report->evidence_path)) {
            Storage::disk('local')->delete($report->evidence_path);
        }
        $report->delete();

        // Pesan sukses untuk delete
        // Redirect kembali ke halaman sebelumnya dari mana aksi delete dilakukan
        return redirect()->back()->with('success', 'Laporan #' . $reportId . ' berhasil dihapus secara permanen.');
    }
}
