<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Event;
use App\Events\ReportSubmitted;

class ReportSubmissionTest extends TestCase
{
    use RefreshDatabase;

    private function getValidReportData($overrides = [])
    {
        Storage::fake('public');

        return array_merge([
            'what_happened' => 'Sebuah insiden terjadi di area perpustakaan.',
            'where_happened' => 'Perpustakaan Pusat, Lantai 3',
            'when_happened' => now()->toDateTimeString(),
            'reporter_role' => 'mahasiswa',
            'has_witness' => 'yes',
            'witness_name' => 'Saksi Mata',
            'witness_relation' => 'teman',
            'knows_perpetrator' => 'yes',
            'perpetrator_name' => 'Terlapor X',
            'perpetrator_role' => 'mahasiswa',
            'evidence' => UploadedFile::fake()->create('bukti.pdf', 100, 'application/pdf'),
            'agreement' => 'on',
        ], $overrides);
    }

    public function test_authenticated_user_can_submit_a_valid_report(): void
    {
        Event::fake();
        $user = User::factory()->create();
        $reportData = $this->getValidReportData();

        $response = $this->actingAs($user)->post(route('reports.store'), $reportData);

        $response->assertRedirect(route('reports.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('report', [
            'user_id' => $user->id,
            'what_happened' => $reportData['what_happened'],
            'status' => 'unread'
        ]);

        $latestReport = \App\Models\Report::latest()->first();
        Storage::disk('public')->assertExists($latestReport->evidence_path);

        Event::assertDispatched(ReportSubmitted::class);
    }

    public function test_report_submission_fails_if_required_field_is_missing(): void
    {
        $user = User::factory()->create();
        $invalidData = $this->getValidReportData(['what_happened' => '']);

        $response = $this->actingAs($user)->post(route('reports.store'), $invalidData);

        $response->assertSessionHasErrors('what_happened');
        $this->assertDatabaseMissing('report', ['user_id' => $user->id]);
    }

    public function test_report_submission_fails_on_conditional_validation(): void
    {
        $user = User::factory()->create();
        $invalidData = $this->getValidReportData([
            'has_witness' => 'yes',
            'witness_name' => ''
        ]);

        $response = $this->actingAs($user)->post(route('reports.store'), $invalidData);

        $response->assertSessionHasErrors('witness_name');
    }

    public function test_unauthenticated_user_is_redirected_from_report_form(): void
    {
        // DIGANTI: route 'reports.create' menjadi 'reports.index'
        $response = $this->get(route('reports.index'));

        $response->assertRedirect(route('login'));
    }
}
