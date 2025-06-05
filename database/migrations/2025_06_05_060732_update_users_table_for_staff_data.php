<?php

// database/migrations/xxxx_xx_xx_xxxxxx_update_users_table_for_staff_data.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Tambahkan kolom 'name' setelah 'id' jika belum ada
            if (!Schema::hasColumn('users', 'name')) {
                $table->string('name')->after('id');
            }

            // Pastikan 'username' ada (sudah ada dari migrasi Anda)
            // Anda mungkin perlu memutuskan apakah 'username' bisa nullable jika 'name' jadi display utama

            // Buat 'phone_number' nullable jika belum
            if (Schema::hasColumn('users', 'phone_number')) {
                $table->string('phone_number')->nullable()->change();
            }

            // Pastikan 'role' ada (sudah ada dari migrasi Anda)

            // Tambahkan 'staff_status' setelah 'role' jika belum ada
            if (!Schema::hasColumn('users', 'staff_status')) {
                $table->string('staff_status')->nullable()->after('role');
            }

            // Tambahkan 'remember_token' jika belum ada
            if (!Schema::hasColumn('users', 'remember_token')) {
                $table->rememberToken();
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'name')) {
                $table->dropColumn('name');
            }
            if (Schema::hasColumn('users', 'staff_status')) {
                $table->dropColumn('staff_status');
            }
            if (Schema::hasColumn('users', 'remember_token')) {
                $table->dropRememberToken();
            }
            // Untuk phone_number, jika sebelumnya not nullable, kembalikan
            // Namun, ini lebih kompleks jika ada data null. Untuk simplisitas,
            // kita bisa abaikan perubahan down() untuk phone_number jika hanya mengubah nullability.
        });
    }
};
