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
        // Ubah 'reports' menjadi 'report' di sini
        Schema::table('report', function (Blueprint $table) {
            // Ubah nama kolom predator_role menjadi perpetrator_role
            // Pastikan Doctrine DBAL terinstal: composer require doctrine/dbal
            // Juga ubah 'reports' menjadi 'report' di dalam Schema::hasColumn
            if (Schema::hasColumn('report', 'predator_role')) {
                $table->renameColumn('predator_role', 'perpetrator_role');
            } elseif (!Schema::hasColumn('report', 'perpetrator_role')) {
                // Jika kolom predator_role tidak ada dan perpetrator_role juga belum ada, buat baru
                // Pastikan kolom 'evidence_path' sudah ada sebelum menggunakan after()
                if (Schema::hasColumn('report', 'evidence_path')) {
                    $table->enum('perpetrator_role', ['mahasiswa', 'staff', 'dosen', 'lainnya', 'tidak_diketahui'])
                          ->nullable() // Sesuaikan nullability jika diperlukan
                          ->after('evidence_path');
                } else {
                    // Jika evidence_path belum ada, tentukan posisi lain atau tambahkan tanpa after()
                    $table->enum('perpetrator_role', ['mahasiswa', 'staff', 'dosen', 'lainnya', 'tidak_diketahui'])
                          ->nullable();
                }
            }

            // Tambahkan kolom baru
            // Pastikan kolom referensi untuk after() sudah ada
            if (Schema::hasColumn('report', 'what_happened')) {
                $table->string('where_happened')->after('what_happened');
            } else {
                $table->string('where_happened');
            }

            if (Schema::hasColumn('report', 'reporter_role')) {
                $table->enum('has_witness', ['yes', 'no'])->default('no')->after('reporter_role');
            } else {
                $table->enum('has_witness', ['yes', 'no'])->default('no');
            }

            if (Schema::hasColumn('report', 'has_witness')) {
                $table->string('witness_name')->nullable()->after('has_witness');
            } else {
                $table->string('witness_name')->nullable();
            }

            if (Schema::hasColumn('report', 'witness_name')) {
                $table->string('witness_relation')->nullable()->after('witness_name');
            } else {
                $table->string('witness_relation')->nullable();
            }

            if (Schema::hasColumn('report', 'witness_relation')) {
                $table->enum('knows_perpetrator', ['yes', 'no'])->default('no')->after('witness_relation');
            } else {
                $table->enum('knows_perpetrator', ['yes', 'no'])->default('no');
            }

            if (Schema::hasColumn('report', 'knows_perpetrator')) {
                $table->string('perpetrator_name')->nullable()->after('knows_perpetrator');
            } else {
                $table->string('perpetrator_name')->nullable();
            }

            // Untuk 'agreement', pastikan kolom 'perpetrator_role' sudah ada (setelah rename atau create)
            // Atau tentukan posisi lain jika 'perpetrator_role' belum pasti ada saat ini
            // Kita bisa letakkan di akhir jika ragu
            $table->boolean('agreement')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Ubah 'reports' menjadi 'report' di sini
        Schema::table('report', function (Blueprint $table) {
            // Hati-hati dengan renameColumn di down(), mungkin lebih aman drop dan add
            // Juga ubah 'reports' menjadi 'report' di dalam Schema::hasColumn
            if (Schema::hasColumn('report', 'perpetrator_role') && !Schema::hasColumn('report', 'predator_role')) {
                 $table->renameColumn('perpetrator_role', 'predator_role');
            }

            $table->dropColumn([
                'where_happened',
                'has_witness',
                'witness_name',
                'witness_relation',
                'knows_perpetrator',
                'perpetrator_name',
                'agreement',
                // Jika perpetrator_role baru dibuat di up() dan tidak ada predator_role sebelumnya,
                // Anda mungkin perlu drop perpetrator_role di sini juga jika kondisi rename tidak terpenuhi.
                // Namun, jika rename berhasil, maka rename balik sudah cukup.
            ]);
        });
    }
};
