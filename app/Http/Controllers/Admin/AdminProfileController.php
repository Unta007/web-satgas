<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Storage;

class AdminProfileController extends Controller
{
    /**
     * Menampilkan halaman form edit profil (termasuk ubah password).
     */
    public function edit()
    {
        $user = Auth::user(); // Mengambil data admin yang sedang login
        return view('admin.profile', compact('user'));
    }

    /**
     * Memperbarui password admin yang sedang login.
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'new_password' => ['required', 'confirmed', Password::defaults()],
        ], [
            'new_password.required' => 'Password baru tidak boleh kosong.',
            'new_password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        $user->password = Hash::make($request->new_password);
        $user->save();

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:5048'],
        ]);

        $user = Auth::user();

        if ($user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }

        $path = $request->file('photo')->store('profile-photos', 'public');

        $user->profile_photo_path = $path;
        $user->save();

        return redirect()->route('admin.profile')->with('success', 'Foto profil berhasil diperbarui!');
    }
}
