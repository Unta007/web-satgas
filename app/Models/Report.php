<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory; 

class Report extends Model
{
    use HasFactory;

    protected $table = 'report';

    protected $fillable = [
        'user_id',
        'what_happened',
        'where_happened',       // Baru
        'when_happened',
        'reporter_role',
        'has_witness',          // Baru
        'witness_name',         // Baru
        'witness_relation',     // Baru
        'knows_perpetrator',    // Baru
        'perpetrator_name',     // Baru
        'perpetrator_role',     // Menggantikan predator_role
        'evidence_path',
        'agreement',
        'status',                // Baru
    ];

    protected $casts = [
        'when_happened' => 'datetime',
        'has_witness' => 'string', // Atau boolean jika tipe kolom di DB adalah boolean
        'knows_perpetrator' => 'string', // Atau boolean jika tipe kolom di DB adalah boolean
        'agreement' => 'boolean',
    ];

    public $timestamps = true;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
