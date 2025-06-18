<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\CustomVerifyEmailNotification;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'phone_number',
        'role',
        'staff_status',
        'password',
        'profile_photo_path',
        'last_seen_at',
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
        'last_seen_at' => 'datetime',
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
     * Kirim notifikasi verifikasi email kustom.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new CustomVerifyEmailNotification);
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

    /**
     * Membuat atribut baru 'profile_photo_url'
     * yang akan berisi URL lengkap ke foto profil.
     */
    public function getProfilePhotoUrlAttribute()
    {
        if ($this->profile_photo_path) {
            // Jika ada path foto, kembalikan URL dari storage
            return asset('storage/' . $this->profile_photo_path);
        }

        // Jika tidak, kembalikan URL default (misalnya dari ui-avatars.com)
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=A40E0E&color=fff';
    }
}
