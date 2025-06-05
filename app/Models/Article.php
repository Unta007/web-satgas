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
}
