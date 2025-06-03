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
        $oldStatus = $report->status; // Simpan status lama untuk perbandingan jika perlu
        $wasArchived = $report->is_archived; // Simpan status arsip lama

        $successMessage = '';
        $redirectRoute = '';

        if ($selectedAction == 'archived') {
            $report->is_archived = true;
            // Status asli ($report->status) tidak diubah saat mengarsipkan
            $successMessage = 'Laporan #' . $report->id . ' berhasil diarsipkan.';
            $redirectRoute = 'admin.reports.archived'; // Arahkan ke halaman arsip
        } else {
            // Jika status diubah ke selain 'archived', maka laporan dianggap tidak diarsipkan lagi
            // dan statusnya diperbarui.
            $report->status = $selectedAction;
            $report->is_archived = false; // Pastikan tidak diarsipkan jika status aktif diubah
            $successMessage = 'Status laporan #' . $report->id . ' berhasil diperbarui menjadi "' . ucfirst($selectedAction) . '".';

            // Tentukan route redirect berdasarkan status baru
            switch ($selectedAction) {
                case 'unread':
                    $redirectRoute = 'admin.reports.unread';
                    break;
                case 'review':
                    $redirectRoute = 'admin.reports.review';
                    break;
                case 'ongoing':
                    $redirectRoute = 'admin.reports.ongoing';
                    break;
                case 'solved':
                    $redirectRoute = 'admin.reports.solved';
                    break;
                case 'denied':
                    $redirectRoute = 'admin.reports.denied';
                    break;
                default:
                    // Fallback jika ada status baru yang belum terdefinisi di sini
                    $redirectRoute = 'admin.reports.unread';
            }
        }

        $report->save();

        // Jika laporan sebelumnya diarsipkan dan sekarang statusnya diubah (menjadi tidak diarsipkan),
        // maka redirect ke halaman status baru.
        // Jika hanya diarsipkan, redirect ke halaman arsip.
        // Jika status diubah dari satu status aktif ke status aktif lainnya, redirect ke halaman status baru.
        if ($redirectRoute) {
            return redirect()->route($redirectRoute)->with('success', $successMessage);
        }

        // Fallback jika $redirectRoute tidak terisi (seharusnya tidak terjadi dengan logika di atas)
        // atau jika Anda ingin kembali ke halaman edit setelah beberapa aksi tertentu.
        // Untuk sekarang, kita selalu redirect ke halaman daftar yang sesuai.
        return redirect()->back()->with('success', $successMessage); // Baris ini bisa dihapus jika redirectRoute selalu terisi
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
