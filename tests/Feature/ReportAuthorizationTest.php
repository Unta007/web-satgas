<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Report;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ReportAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_their_own_report_detail(): void
    {
        $this->withoutVite(); // DITAMBAHKAN untuk mengatasi error manifest

        $user = User::factory()->create();
        $report = Report::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('reports.show', $report));

        $response->assertStatus(200);
        $response->assertViewIs('user.show-report');
        $response->assertSee($report->what_happened);
    }

    public function test_user_cannot_view_another_users_report_detail(): void
    {
        $this->withoutVite(); // Tambahkan juga di sini untuk konsistensi

        $userA = User::factory()->create();
        $userB = User::factory()->create();
        $reportOwnedByA = Report::factory()->create(['user_id' => $userA->id]);

        $response = $this->actingAs($userB)->get(route('reports.show', $reportOwnedByA));

        $response->assertRedirect();
        $response->assertSessionHas('error');
    }

    public function test_user_can_download_their_own_evidence(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $file = UploadedFile::fake()->create('my-evidence.pdf');
        $path = $file->store('evidence_uploads', 'public');

        $report = Report::factory()->create([
            'user_id' => $user->id,
            'evidence_path' => $path
        ]);

        // DIGANTI: dari 'user.reports.downloadEvidence' menjadi 'reports.downloadEvidence'
        $response = $this->actingAs($user)->get(route('reports.downloadEvidence', $report));

        $response->assertStatus(200);
        $response->assertDownload(basename($report->evidence_path));
    }

    public function test_user_cannot_download_another_users_evidence(): void
    {
        Storage::fake('public');
        $userA = User::factory()->create();
        $userB = User::factory()->create();
        $file = UploadedFile::fake()->create('secret-evidence.pdf');
        $path = $file->store('evidence_uploads', 'public');
        $reportOwnedByA = Report::factory()->create(['user_id' => $userA->id, 'evidence_path' => $path]);

        // DIGANTI: dari 'user.reports.downloadEvidence' menjadi 'reports.downloadEvidence'
        $response = $this->actingAs($userB)->get(route('reports.downloadEvidence', $reportOwnedByA));

        $response->assertRedirect();
        $response->assertSessionHas('error');
    }
}
