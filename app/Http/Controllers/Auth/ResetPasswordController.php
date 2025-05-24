<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Hash; // Tambahkan ini
use App\Models\User;                 // Tambahkan ini
use Illuminate\Support\Facades\Log;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/'; // Ganti dengan path redirect yang Anda inginkan

    /**
     * Get the password reset validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => [
                'required',
                'confirmed',
                'min:8',
                function ($attribute, $value, $fail) {
                    Log::info('--- Validasi Password Kustom Dimulai ---');
                    $email = request()->input('email');
                    Log::info('Email dari request: ' . $email);

                    if (!$email) {
                        Log::warning('Email tidak ditemukan dalam request.');
                        return;
                    }

                    $user = User::where('email', $email)->first();
                    if (!$user) {
                        Log::warning('User dengan email ' . $email . ' tidak ditemukan.');
                        return;
                    }
                    Log::info('User ditemukan: ' . $user->email);
                    Log::info('Password baru (plain): ' . $value);
                    // Jangan log password user yang sudah di-hash ($user->password) secara langsung ke log produksi.
                    // Untuk debugging lokal, Anda bisa sementara melihatnya jika perlu, tapi hati-hati.

                    $isSamePassword = Hash::check($value, $user->password);
                    Log::info('Apakah password sama? ' . ($isSamePassword ? 'Ya' : 'Tidak'));

                    if ($isSamePassword) {
                        Log::info('Password sama, memanggil $fail().');
                        $fail(__('Password baru tidak boleh sama dengan password Anda saat ini.'));
                    }
                    Log::info('--- Validasi Password Kustom Selesai ---');
                },
            ],
        ];
    }

    /**
     * Get the password reset validation error messages.
     *
     * @return array
     */
    protected function validationErrorMessages()
    {
        // Anda bisa menambahkan pesan error kustom untuk aturan lain di sini jika perlu
        // Contoh:
        // return [
        //     'password.min' => 'Password minimal harus :min karakter.',
        // ];
        return [];
    }
}
