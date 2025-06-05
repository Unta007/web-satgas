<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::whereIn('role', ['admin', 'global_admin'])
                        ->latest()
                        ->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'], // Pastikan unique rule-nya benar jika name juga harus unik
            'username' => ['required', 'string', 'max:255', 'alpha_dash', 'unique:users,username'],
            'email' => ['required', 'string', 'email:dns', 'max:255', 'unique:users,email'],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:admin,global_admin'],
            'staff_status' => ['required', 'string', 'in:Dosen,Mahasiswa,TPA'],
        ]);

        // Simpan user yang baru dibuat ke dalam variabel
        $newUser = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'staff_status' => $request->staff_status,
            'email_verified_at' => now(),
        ]);

        // Gunakan variabel $newUser untuk logging
        activity()
            ->causedBy(Auth::user())
            ->performedOn($newUser) // <-- KOREKSI: Gunakan $newUser
            ->log("<strong>menambahkan</strong> pengguna baru: <strong>{$newUser->name}</strong> (Izin Akses: <strong>{$newUser->role}</strong>, Status Staff: <strong>{$newUser->staff_status}</strong>).");

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        if (!in_array($user->role, ['admin', 'global_admin'])) {
            return redirect()->route('admin.users.index')->with('error', 'Pengguna dengan peran "user" tidak dapat dikelola dari sini.');
        }
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if (!in_array($user->role, ['admin', 'global_admin'])) {
            return redirect()->route('admin.users.index')->with('error', 'Pengguna dengan peran "user" tidak dapat dikelola dari sini.');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'], // Hapus unique rule jika tidak perlu, atau pastikan benar: 'unique:users,name,'.$user->id
            'username' => ['required', 'string', 'max:255', 'alpha_dash', 'unique:users,username,'.$user->id],
            'email' => ['required', 'string', 'email:dns', 'max:255', 'unique:users,email,'.$user->id],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:admin,global_admin'],
            'staff_status' => ['required', 'string', 'in:Dosen,Mahasiswa,TPA'],
        ]);

        // KOREKSI: Ambil nilai lama SEBELUM update
        $oldRole = $user->role;
        $oldStaffStatus = $user->staff_status;
        // Anda juga bisa menyimpan $oldName, $oldEmail, dll. jika ingin mencatatnya di log

        $data = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'role' => $request->role,
            'staff_status' => $request->staff_status,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data); // $user sekarang memiliki nilai baru

        // Buat deskripsi log yang detail
        $logDescription = "<strong>mengedit</strong> data staff: <strong>{$user->name}</strong>.";
        if ($oldRole !== $request->role) {
            $logDescription .= " Izin akses diubah dari <strong>'{$oldRole}'</strong> menjadi <strong>'{$request->role}'</strong>.";
        }
        if ($oldStaffStatus !== $request->staff_status) { // Bandingkan dengan nilai request
            $logDescription .= " Status Staff diubah dari <strong>'{$oldStaffStatus}'</strong> menjadi <strong>'{$request->staff_status}'</strong>.";
        }
        // Tambahkan detail perubahan lain jika perlu

        activity()
            ->causedBy(Auth::user())
            ->performedOn($user)
            ->log($logDescription);

        return redirect()->route('admin.users.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if (!in_array($user->role, ['admin', 'global_admin'])) {
            return redirect()->route('admin.users.index')->with('error', 'Pengguna dengan peran "user" tidak dapat dihapus dari sini.');
        }

        // KOREKSI: Simpan detail SEBELUM menghapus $user
        $deletedUserName = $user->name;
        $deletedUserRole = $user->role; // Simpan detail lain jika perlu
        $deletedUserStatus = $user->staff_status;
        $deletedUserId = $user->id;
        $adminName = Auth::user()->name;


        $user->delete();

        activity()
            ->causedBy(Auth::user())
            // ->performedOn($user) // $user sudah dihapus, jadi performedOn tidak bisa diisi dengan objek yang sudah didelete
            // Sebaiknya gunakan withProperties untuk menyimpan ID dan detail penting lainnya
            ->withProperties(['deleted_user_id' => $deletedUserId, 'name' => $deletedUserName, 'role' => $deletedUserRole, 'staff_status' => $deletedUserStatus])
            ->log("<strong>menghapus</strong> staff: <strong>{$deletedUserName}</strong> (Izin Akses: <strong>{$deletedUserRole}</strong>, Status Staff: <strong>{$deletedUserStatus}</strong>).");

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
