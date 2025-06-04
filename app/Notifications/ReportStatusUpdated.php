<?php

namespace App\Notifications;

use App\Models\Report; // Pastikan model Report di-import
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString; // Untuk format HTML sederhana jika diperlukan

class ReportStatusUpdated extends Notification implements ShouldQueue // Opsional: implementasi ShouldQueue jika ingin notifikasi di-handle oleh queue
{
    use Queueable;

    public $report;
    public $newStatus;
    public $oldStatus; // Opsional: jika ingin menyimpan status lama

    /**
     * Create a new notification instance.
     *
     * @param \App\Models\Report $report
     * @param string $newStatus
     * @param string|null $oldStatus
     */
    public function __construct(Report $report, string $newStatus, ?string $oldStatus = null)
    {
        $this->report = $report;
        $this->newStatus = $newStatus;
        $this->oldStatus = $oldStatus;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        // Kita akan menggunakan channel 'database' untuk menyimpan notifikasi di database
        // Anda juga bisa menambahkan 'mail' jika ingin mengirim email
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     * (Hanya jika Anda menggunakan channel 'mail')
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    // public function toMail($notifiable)
    // {
    //     return (new MailMessage)
    //                 ->line('Laporan Anda telah diperbarui.')
    //                 ->action('Lihat Laporan', url('/reports/' . $this->report->id)) // Sesuaikan URL
    //                 ->line('Status baru: ' . ucfirst($this->newStatus));
    // }

    /**
     * Get the array representation of the notification.
     * Ini adalah data yang akan disimpan di kolom 'data' pada tabel notifications.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        // $reportUrl = route('reports.show', $this->report->id);

        return [
            'report_id' => $this->report->id,
            'report_title' => 'Laporan #' . $this->report->id,
            'message_raw' => "Status laporan Anda (#" . $this->report->id . ") saat ini: " . ucfirst($this->newStatus) . ".",
            'message_html' => "Status laporan Anda (<strong>#" . $this->report->id . "</strong>) saat ini: <strong>" . ucfirst($this->newStatus) . "</strong>.",
            'url' => route('reports.show', $this->report->id),
            'new_status' => $this->newStatus,
            'old_status' => $this->oldStatus,
        ];
    }

    /**
     * Get the database representation of the notification.
     * (Alternatif untuk toArray jika Anda ingin format berbeda khusus untuk database)
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        // Mirip dengan toArray, data ini akan disimpan di kolom 'data'
        return [
            'report_id' => $this->report->id,
            'report_title' => 'Laporan #' . $this->report->id,
            'message_raw' => "Status laporan Anda (#" . $this->report->id . ") saat ini: " . ucfirst($this->newStatus) . ".",
            'message_html' => "Status laporan Anda (<strong>#" . $this->report->id . "</strong>) saat ini: <strong>" . ucfirst($this->newStatus) . "</strong>.",
            'url' => route('reports.show', $this->report->id), // Ganti dengan route detail laporan untuk user
            'new_status' => $this->newStatus,
            'old_status' => $this->oldStatus,
        ];
    }
}
