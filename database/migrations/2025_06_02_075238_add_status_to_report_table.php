<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('report', function (Blueprint $table) {
            // Menambahkan kolom status setelah kolom 'evidence_path'
            $table->enum('status', ['review', 'ongoing', 'solved', 'denied', 'archived'])
                  ->default('review') // Set nilai default saat laporan dibuat
                  ->after('evidence_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('report', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
