<?php

namespace App\Notifications;

use App\Models\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewReportSubmitted extends Notification implements ShouldQueue
{
    use Queueable;

    public $report;

    /**
     * Create a new notification instance.
     */
    public function __construct(Report $report)
    {
        $this->report = $report;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable): array
    {
        return ['mail']; // Kita hanya akan mengirim via email untuk notifikasi ini
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        $reportUrl = route('admin.reports.edit', $this->report->id); // URL ke halaman detail laporan di admin dashboard

        return (new MailMessage)
            ->subject('Laporan Baru Telah Diterima: #' . $this->report->id)
            ->greeting('Halo Admin,')
            ->line('Sebuah laporan baru telah masuk ke dalam sistem.')
            ->line('**ID Laporan:** #' . $this->report->id)
            ->line('**Tanggal Dilaporkan:** ' . $this->report->created_at->format('d F Y, H:i'))
            ->action('Tinjau Laporan Sekarang', $reportUrl)
            ->line('Mohon untuk segera meninjau dan memproses laporan ini.')
            ->salutation('Terima kasih.');
    }
}
