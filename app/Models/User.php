<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\MyCustomResetPasswordNotification; // Buat notifikasi kustom ini
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification; // Default notification

class User extends Authenticatable implements MustVerifyEmail
{
    // Tambahkan HasApiTokens di sini
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    public function sendPasswordResetNotification($token)
    {
        // Jika ingin menggunakan notifikasi default dengan URL kustom:
        // $url = url(route('password.reset', [
        //     'token' => $token,
        //     'email' => $this->getEmailForPasswordReset(),
        // ], false));
        // $this->notify(new ResetPasswordNotification($url)); // Ini contoh jika ingin custom URL

        // Atau, jika Anda membuat kelas Notifikasi sendiri:
        // $this->notify(new MyCustomResetPasswordNotification($token, $this->email));

        // Default Laravel (jika Anda tidak override, ini yang digunakan):
        parent::sendPasswordResetNotification($token);
    }


    protected $fillable = [
        'username',
        'email',
        'phone_number',
        'role',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
