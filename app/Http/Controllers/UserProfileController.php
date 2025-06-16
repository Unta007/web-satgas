<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class UserProfileController extends Controller
{
    /**
     * Menampilkan halaman profil pengguna dan riwayat laporannya.
     */
    public function show()
    {
        $user = Auth::user();

        // Ambil riwayat laporan milik pengguna yang sedang login
        $reports = Report::where('user_id', $user->id)
            ->latest()
            ->get();

        return view('user.profile', compact('user', 'reports'));
    }

    /**
     * Memperbarui foto profil pengguna.
     */
    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        $user = Auth::user();

        // Hapus foto lama jika ada
        if ($user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }

        // Simpan foto baru
        $path = $request->file('photo')->store('profile-photos', 'public');
        $user->profile_photo_path = $path;
        $user->save();

        return back()->with('success', 'Foto profil berhasil diperbarui!');
    }

    /**
     * Memperbarui detail email.
     */
    public function updateDetails(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            // PERBAIKAN DAN PENAMBAHAN VALIDASI PADA EMAIL
            'email' => [
                'required',
                'string',
                'email:dns',
                'max:255',
                'unique:users,email,' . $user->id, //

                // ATURAN BARU: pastikan email baru tidak sama dengan email saat ini
                function ($attribute, $value, $fail) use ($user) {
                    if ($value === $user->email) {
                        $fail('Alamat email baru tidak boleh sama dengan email Anda saat ini.');
                    }
                },
            ],
            'current_password_for_details' => ['required', 'string'],
        ]);

        // Verifikasi password saat ini (logika ini tetap sama)
        if (!Hash::check($request->current_password_for_details, $user->password)) {
            return back()->withErrors(['current_password_for_details' => 'Password yang Anda masukkan salah.'])->withInput();
        }

        // Jika email diubah, reset verifikasi email (logika ini tetap sama)
        if ($request->email !== $user->email) {
            $user->email = $request->email;
            $user->email_verified_at = null;
            $user->sendEmailVerificationNotification();
        }

        $user->save();

        return back()->with('success', 'Detail akun berhasil diperbarui. Jika Anda mengubah email, silakan cek email baru Anda untuk verifikasi.');
    }

    /**
     * Memperbarui password pengguna.
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => ['required', 'string'],
            'new_password' => [
                'required',
                'min:8', // Aturan ini bagus, tapi Password::defaults() sudah mencakupnya
                'confirmed',
                Password::defaults(),

                // ATURAN BARU: pastikan password baru tidak sama dengan password saat ini
                function ($attribute, $value, $fail) use ($user) {
                    if (Hash::check($value, $user->password)) {
                        $fail('Password baru tidak boleh sama dengan password Anda saat ini.');
                    }
                },
            ],
        ]);

        // Verifikasi password saat ini (logika ini tetap sama)
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama yang Anda masukkan salah.'])->withInput();
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        // Logout dan redirect (logika ini tetap sama)
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('status', 'Password berhasil diubah. Silakan login kembali.');
    }
}
