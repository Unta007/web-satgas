<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'phone_number',
        'role', // Pastikan kolom 'role' ada di migrasi dan bisa menyimpan 'user', 'admin', 'global_admin'
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token', // Ditambahkan untuk praktik standar
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        // Jika kolom 'role' Anda adalah ENUM di database, tidak perlu cast khusus di sini
        // kecuali jika Anda menggunakan PHP 8.1+ Enums dan ingin meng-cast ke objek Enum.
        // Untuk string biasa ('admin', 'global_admin', 'user'), tidak perlu cast tambahan.
    ];

    /**
     * Send the password reset notification.
     * Metode ini sudah baik jika Anda menggunakan alur default atau kustomisasi di dalamnya.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        // Logika kustom Anda atau panggilan ke parent:: sudah cukup.
        // Contoh: $this->notify(new \App\Notifications\CustomResetPasswordNotification($token));
        parent::sendPasswordResetNotification($token);
    }

    /**
     * Memeriksa apakah pengguna memiliki akses admin (peran 'admin' atau 'global_admin').
     *
     * @return bool
     */
    public function hasAdminAccess(): bool
    {
        return in_array($this->role, ['admin', 'global_admin']);
    }

    /**
     * Memeriksa apakah pengguna adalah Global Admin secara spesifik.
     * (Opsional, berguna jika ada logika yang hanya untuk global_admin)
     *
     * @return bool
     */
    public function isGlobalAdmin(): bool
    {
        return $this->role === 'global_admin';
    }
}
