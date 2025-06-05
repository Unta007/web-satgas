<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Pastikan path ke model User Anda benar
use Illuminate\Support\Str; // Untuk Str::slug dan Str::random

class StaffToUsersSeeder extends Seeder
{
    // public function run(): void
    // {
    //     $oldStaffMembers = DB::table('staff')->get();

    //     foreach ($oldStaffMembers as $staff) {
    //         $existingUser = User::where('email', $staff->email)->first();

    //         if ($existingUser) {
    //             $this->command->warn("User dengan email {$staff->email} sudah ada di tabel users. Melewati staf: ID Staff Lama #{$staff->id} - {$staff->name}");
    //             continue;
    //         }

    //         // Mapping 'access_clearance' (dari tabel staff) ke 'role' (di tabel users)
    //         $role = 'user'; // Default role
    //         if (strtolower($staff->access_clearance) === 'superadmin') {
    //             $role = 'global_admin'; // Sesuai enum di tabel users Anda
    //         } elseif (strtolower($staff->access_clearance) === 'admin') {
    //             $role = 'admin';
    //         } elseif (strtolower($staff->access_clearance) === 'staff') {
    //             // Anda perlu memutuskan 'Staff' dari tabel lama akan jadi role apa.
    //             // Misal, jika 'Staff' adalah admin juga:
    //             $role = 'admin';
    //             // Atau jika Anda ingin 'staff' sebagai role baru, Anda harus menambahkannya ke enum 'role' di tabel users.
    //         }

    //         // Menangani 'username'. Tabel 'users' memiliki 'username', tabel 'staff' memiliki 'name'.
    //         // Kita akan gunakan 'name' dari staff untuk 'name' di users.
    //         // Untuk 'username', kita bisa generate dari email atau nama, pastikan unik.
    //         $baseUsername = Str::slug(explode('@', $staff->email)[0], '_');
    //         $username = $baseUsername;
    //         $counter = 1;
    //         while (User::where('username', $username)->exists()) {
    //             $username = $baseUsername . '_' . $counter;
    //             $counter++;
    //         }

    //         User::create([
    //             'name' => $staff->name, // Dari staff.name
    //             'username' => $username, // Username yang digenerate
    //             'email' => $staff->email,
    //             'phone_number' => null, // Staff tidak punya phone_number, jadi null
    //             'role' => $role,
    //             'staff_status' => $staff->staff_status, // Dari staff.staff_status
    //             'email_verified_at' => $staff->email_verified_at ?? now(), // Jika null di staff, verifikasi sekarang
    //             'password' => $staff->password, // Asumsi password sudah di-hash di tabel staff
    //             'remember_token' => $staff->remember_token ?? Str::random(10), // Dari staff.remember_token
    //             'created_at' => $staff->created_at,
    //             'updated_at' => $staff->updated_at,
    //         ]);

    //         $this->command->info("Staf '{$staff->name}' (ID Lama #{$staff->id}) berhasil dimigrasikan ke tabel users sebagai '{$username}' dengan role '{$role}'.");
    //     }

    //     $this->command->info('Proses migrasi data staf ke users selesai.');
    // }
}
