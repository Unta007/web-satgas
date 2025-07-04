<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmergencyContact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'contact_info',
        'description',
        'icon',
        'is_active',
        'order',
    ];
}
