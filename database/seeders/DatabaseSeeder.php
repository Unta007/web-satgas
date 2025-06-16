<?php

namespace Database\Seeders;

use App\Models\User; // Import User
use App\Models\Report; // Import Report
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // User::factory(200)->create([
        //     'role' => 'user'
        // ]);

        // Report::factory(50)->unread()->create();
        // Report::factory(50)->review()->create();
        // Report::factory(50)->ongoing()->create();
        // Report::factory(50)->solved()->create();
        // Report::factory(50)->denied()->create();

        // Contoh menggunakan state untuk membuat laporan dengan status spesifik:
        // Report::factory(10)->unread()->create();
        // Report::factory(5)->review()->create();

    }
}
