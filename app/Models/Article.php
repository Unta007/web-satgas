<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'title',
        'author',
        'description',
        'slug',
        'image',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function getReadingTimeAttribute(): string
    {
        // Hitung jumlah kata. strip_tags() penting untuk menghapus tag HTML dari deskripsi.
        $wordCount = str_word_count(strip_tags($this->description));

        // Bagi jumlah kata dengan kecepatan baca rata-rata (misal, 200 kpm)
        // ceil() digunakan untuk membulatkan ke atas. 1.2 menit akan menjadi 2 menit.
        $minutes = ceil($wordCount / 200);

        // Jika hasilnya 0 atau 1, tampilkan "1 menit baca"
        if ($minutes < 2) {
            return '1 menit baca';
        }

        return $minutes . ' menit baca';
    }
}
