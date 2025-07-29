<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Report;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ReportStatusUpdated;

class ReportTest extends TestCase
{
    use RefreshDatabase;

    private $admin;
    private $user;

    // Method setUp dijalankan sebelum setiap tes di dalam class ini
    protected function setUp(): void
    {
        parent::setUp();
        // Buat satu admin dan satu user untuk digunakan di semua tes
        $this->admin = User::factory()->create(['role' => 'admin']);
        $this->user = User::factory()->create(['role' => 'user']);
        // Mencegat notifikasi agar tidak benar-benar dikirim, dan memungkinkan kita untuk memeriksanya
        Notification::fake();
    }

    /**
     * KASUS UJI 1: Alur normal, mengubah status dari 'unread' ke 'review'.
     */
    public function test_can_change_status_from_unread_to_review(): void
    {
        $report = Report::factory()->create(['user_id' => $this->user->id, 'status' => 'unread']);

        $response = $this->actingAs($this->admin)
            ->put(route('admin.reports.updateStatus', $report), ['status' => 'review']);

        $response->assertRedirect(route('admin.reports.review'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('report', ['id' => $report->id, 'status' => 'review']);

        // Verifikasi bahwa notifikasi dikirim ke pemilik laporan
        Notification::assertSentTo(
            [$this->user],
            ReportStatusUpdated::class
        );
    }

    /**
     * KASUS UJI 2: Menguji alur 'denied' dengan catatan penolakan.
     */
    public function test_can_deny_report_with_rejection_note(): void
    {
        $report = Report::factory()->create(['user_id' => $this->user->id, 'status' => 'review']);
        $note = 'Bukti yang dilampirkan tidak valid.';

        $response = $this->actingAs($this->admin)
            ->put(route('admin.reports.updateStatus', $report), [
                'status' => 'denied',
                'rejection_note' => $note,
            ]);

        $response->assertRedirect(route('admin.reports.denied'));
        $this->assertDatabaseHas('report', [
            'id' => $report->id,
            'status' => 'denied',
            'rejection_note' => $note
        ]);

        // Verifikasi notifikasi dikirim dan berisi catatan
        Notification::assertSentTo($this->user, function (ReportStatusUpdated $notification) use ($note) {
            return $notification->rejectionNote === $note;
        });
    }

    /**
     * KASUS UJI 3: Menguji validasi, menolak laporan tanpa catatan akan gagal.
     */
    public function test_denying_report_fails_without_a_note(): void
    {
        $report = Report::factory()->create(['user_id' => $this->user->id, 'status' => 'review']);

        $response = $this->actingAs($this->admin)
            ->put(route('admin.reports.updateStatus', $report), [
                'status' => 'denied',
                'rejection_note' => '', // Catatan sengaja dikosongkan
            ]);

        // Memastikan proses kembali dengan error validasi
        $response->assertSessionHasErrors('rejection_note');
        // Memastikan status di database TIDAK berubah
        $this->assertEquals('review', $report->fresh()->status);

        // Memastikan notifikasi TIDAK terkirim
        Notification::assertNothingSent();
    }
}
