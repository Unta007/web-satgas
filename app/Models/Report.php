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
        'where_happened',
        'when_happened',
        'reporter_role',
        'has_witness',
        'witness_name',
        'witness_relation',
        'knows_perpetrator',
        'perpetrator_name',
        'perpetrator_role',
        'evidence_path',
        'agreement',
        'status',
        'is_archived',
    ];

    protected $casts = [
        'when_happened' => 'datetime',
        'has_witness' => 'string',
        'knows_perpetrator' => 'string',
        'agreement' => 'boolean',
    ];

    public $timestamps = true;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
