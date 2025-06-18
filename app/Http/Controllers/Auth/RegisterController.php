<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered; // 1. Tambahkan impor ini

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/'; // Ini akan menjadi fallback jika verifikasi tidak diperlukan atau sudah terverifikasi

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = $this->create($request->all());

        event(new Registered($user)); // 2. Kirim event Registered setelah user dibuat

        Auth::login($user); // Loginkan pengguna

        // 3. Arahkan ke halaman pemberitahuan verifikasi jika perlu
        if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }

        return redirect($this->redirectTo);
    }

    protected function validator(array $data)
    {
        $rules = [
            'username' => ['required', 'string', 'min:4', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email:dns', 'max:255', 'unique:users'],
            'phone_number' => ['required', 'string', 'digits_between:10,15', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];

        $messages = [
            'username.required' => 'Username wajib diisi.',
            'username.min' => 'Username minimal harus :min karakter.',
            'username.max' => 'Username tidak boleh lebih dari :max karakter.',
            'username.unique' => 'Username ini sudah digunakan, silakan pilih yang lain.',

            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'email.dns' => 'Domain email tidak dapat dijangkau, pastikan email Anda aktif.',
            'email.unique' => 'Alamat email ini sudah terdaftar.',

            'phone_number.required' => 'Nomor telepon wajib diisi.',
            'phone_number.digits_between' => 'Nomor telepon harus terdiri dari :min hingga :max digit angka.',
            'phone_number.unique' => 'Nomor telepon ini sudah terdaftar.',

            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal harus :min karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ];

        return Validator::make($data, $rules, $messages);
    }

    protected function create(array $data)
    {
        return User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'phone_number' => $data['phone_number'],
            'password' => Hash::make($data['password']),
            'role' => 'user',
        ]);
    }
}
