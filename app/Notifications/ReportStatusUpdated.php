<?php

namespace App\Notifications;

use App\Models\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReportStatusUpdated extends Notification implements ShouldQueue
{
    use Queueable;

    public $report;
    public $newStatus;
    public $oldStatus;
    public $rejectionNote;

    /**
     * Create a new notification instance.
     */
    public function __construct(Report $report, $newStatus, $oldStatus, $rejectionNote = null)
    {
        $this->report = $report;
        $this->newStatus = $newStatus;
        $this->oldStatus = $oldStatus;
        $this->rejectionNote = $rejectionNote;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the database representation of the notification.
     * Method ini akan kita modifikasi untuk menyimpan data yang lebih kaya.
     */
    public function toDatabase($notifiable): array
    {
        $reportId = $this->report->id;
        $newStatusUcfirst = ucfirst($this->newStatus);

        $message_raw = '';
        $message_html = '';
        $icon = 'bi-info-circle-fill text-primary'; // Ikon default

        // Membuat pesan dinamis berdasarkan status baru
        switch ($this->newStatus) {
            case 'denied':
                $message_raw = "Laporan Anda (#{$reportId}) ditolak. Admin telah memberikan catatan.";
                $message_html = "Laporan Anda (<strong>#{$reportId}</strong>) telah <strong>ditolak</strong>. Silakan lihat detail laporan untuk catatan dari admin.";
                $icon = 'bi-x-circle-fill text-danger'; // Ikon untuk ditolak
                break;

            case 'solved':
                $message_raw = "Kabar baik! Laporan Anda (#{$reportId}) telah diselesaikan.";
                $message_html = "Kabar baik! Laporan Anda (<strong>#{$reportId}</strong>) telah <strong>diselesaikan</strong>.";
                $icon = 'bi-check-circle-fill text-success'; // Ikon untuk selesai
                break;

            case 'ongoing':
                $message_raw = "Laporan Anda (#{$reportId}) sedang dalam penanganan oleh tim kami.";
                $message_html = "Laporan Anda (<strong>#{$reportId}</strong>) sedang dalam <strong>penanganan</strong> oleh tim kami.";
                $icon = 'bi-arrow-repeat text-warning'; // Ikon untuk sedang berjalan
                break;

            default: // Untuk status 'unread', 'review', dll.
                $message_raw = "Status laporan Anda (#{$reportId}) diperbarui menjadi: {$newStatusUcfirst}.";
                $message_html = "Status laporan Anda (<strong>#{$reportId}</strong>) diperbarui menjadi: <strong>{$newStatusUcfirst}</strong>.";
                break;
        }

        // Ini adalah data final yang akan disimpan di kolom 'data' (format JSON) pada tabel notifications
        return [
            'report_id' => $reportId,
            'message_raw' => $message_raw,
            'message_html' => $message_html,
            'url' => route('reports.show', $this->report->id),
            'icon' => $icon, // Simpan ikon untuk tampilan UI yang lebih baik
            'new_status' => $this->newStatus,
            'old_status' => $this->oldStatus,
            'rejection_note' => $this->rejectionNote, // <-- SIMPAN CATATAN PENOLAKAN DI SINI
        ];
    }

    /**
     * Get the array representation of the notification.
     * (Tidak digunakan jika toDatabase ada, tapi baik untuk tetap ada sebagai fallback)
     */
    public function toArray($notifiable): array
    {
        // Kita bisa panggil toDatabase agar datanya konsisten
        return $this->toDatabase($notifiable);
    }

    public function toMail($notifiable)
    {
        $newStatusUcfirst = ucfirst($this->newStatus);
        $reportUrl = route('reports.show', $this->report->id);

        // Memulai pembuatan email
        $mailMessage = (new MailMessage)
            ->subject('Update Status Laporan Anda #' . $this->report->id)
            ->greeting('Halo, ' . $notifiable->username . '!');

        // Menambahkan baris pesan utama berdasarkan status
        switch ($this->newStatus) {
            case 'denied':
                $mailMessage->line("Dengan berat hati kami informasikan bahwa laporan Anda (#{$this->report->id}) telah ditolak.");
                break;
            case 'solved':
                $mailMessage->line("Kabar baik! Laporan Anda (#{$this->report->id}) telah selesai diproses dan statusnya kini telah Diselesaikan.");
                break;
            default:
                $mailMessage->line("Ada pembaruan untuk laporan Anda (#{$this->report->id}). Statusnya kini adalah '{$newStatusUcfirst}'.");
                break;
        }

        // Menambahkan catatan penolakan jika ada (hanya untuk status 'denied')
        if (!empty($this->rejectionNote)) {
            $mailMessage->line("\n**Laporan Anda ditolak dengan alasan berikut:**")
                ->line(new \Illuminate\Support\HtmlString(nl2br(e($this->rejectionNote))));
        }

        // Menambahkan tombol aksi dan kalimat penutup
        $mailMessage->action('Lihat Detail Laporan', $reportUrl)
            ->line('Terima kasih telah menggunakan platform kami untuk menciptakan lingkungan yang lebih aman.')
            ->salutation('Hormat kami, Tim Satgas PPKS Kampus Surabaya');

        return $mailMessage;
    }
}
