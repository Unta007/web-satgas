<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Report;
use Illuminate\Support\Facades\Storage;
use App\Notifications\ReportStatusUpdated;
use Illuminate\Support\Facades\Auth;


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
            ->where('is_archived', false)
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
            ->where('is_archived', false)
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
            ->where('is_archived', false)
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
            ->where('is_archived', false)
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
            ->where('is_archived', false)
            ->with('user')
            ->latest()
            ->get();

        return view('admin.reports.denied', [
            'reports' => $reports,
        ]);
    }

    public function archived(Request $request)
    {
        $reports = Report::where('is_archived', true)
            ->with('user')
            ->latest('updated_at')
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

        // 1. TAMBAHKAN VALIDASI UNTUK REJECTION NOTE
        $request->validate([
            'status' => ['required', Rule::in($availableStatusesForLogic)],
            'rejection_note' => ['nullable', 'string', 'max:2000'], // Boleh kosong, tapi jika ada harus string
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
                // Kita akan tambahkan logika pesan sukses untuk update note di bawah
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

        // 2. BLOK TAMBAHAN UNTUK MENANGANI DATA REJECTION NOTE
        // Diletakkan tepat sebelum $report->save()
        // --------------------------------------------------------------------
        if ($selectedAction === 'denied') {
            $rejectionNote = $request->input('rejection_note');
            // Validasi server-side untuk memastikan catatan diisi jika status ditolak
            if (empty($rejectionNote)) {
                return back()->withErrors(['rejection_note' => 'Catatan penolakan wajib diisi jika status adalah Ditolak.'])->withInput();
            }
            // Jika status adalah 'denied' dan catatan berubah, perbarui pesan sukses
            if ($report->rejection_note != $rejectionNote) {
                $successMessage = 'Status dan catatan penolakan berhasil diperbarui.';
            }
            $report->rejection_note = $rejectionNote;
        } else {
            // Jika status BUKAN 'denied', selalu pastikan catatan penolakan kosong
            $report->rejection_note = null;
        }
        // --------------------------------------------------------------------

        $report->save();

        // Blok activity log Anda (tidak ada perubahan)
        if ($statusChangedForUserNotification) {
            activity()
                ->causedBy(Auth::user())
                ->performedOn($report)
                ->withProperties(['old_status' => $oldStatus, 'new_status' => $selectedAction, 'was_archived' => $wasArchived])
                ->log("<strong>mengubah</strong> status laporan <strong>#{$report->id}</strong> dari <strong>'{$oldStatus}'</strong> menjadi <strong>'{$selectedAction}'</strong>" . ($report->is_archived && !$wasArchived ? ' dan mengarsipkan.' : ($wasArchived && !$report->is_archived ? ' dan mengeluarkan dari arsip.' : '.')));
        } elseif ($selectedAction == 'archived' && !$wasArchived) {
            activity()
                ->causedBy(Auth::user())
                ->performedOn($report)
                ->log("<strong>mengarsipkan</strong> laporan <strong>#{$report->id}</strong>.");
        }

        // Blok notifikasi user
        if ($statusChangedForUserNotification && $report->user && $selectedAction !== 'archived') {
            $reportOwner = $report->user;
            if ($reportOwner) {
                try {
                    // 3. TAMBAHKAN REJECTION NOTE SAAT MENGIRIM NOTIFIKASI
                    $reportOwner->notify(new ReportStatusUpdated($report, $selectedAction, $oldStatus, $report->rejection_note));
                } catch (\Exception $e) {
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
        $oldStatus = $report->status;

        if ($report->evidence_path && Storage::disk('local')->exists($report->evidence_path)) {
            Storage::disk('local')->delete($report->evidence_path);
        }
        $report->delete();

        activity()
            ->causedBy(Auth::user())
            ->withProperties(['report_id' => $reportId, 'old_status' => $oldStatus,])
            ->log("<strong>menghapus</strong> laporan <strong>#{$report->id}</strong> dari list <strong>'{$oldStatus}'</strong>.");

        return redirect()->back()->with('success', 'Laporan #' . $reportId . ' berhasil dihapus secara permanen.');
    }
}
