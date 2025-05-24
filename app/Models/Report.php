<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Report extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'report'; // Secara eksplisit set nama tabel, meskipun defaultnya sudah 'report'

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'what_happened',
        'when_happened',
        'report_role',
        'evidence_path',
        'file_path', // Ini mungkin perlu dicek ulang penamaannya
        'predator_role', //dan bagaimana kaitannya dengan perpetrator
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'when_happened' => 'datetime',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true; // Secara default true, tapi baik untuk eksplisit

    /**
     * Get the user that made the report.
     * Relasi one-to-many terbalik (belongsTo)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id'); //->withDefault(); // Tidak perlu withDefault disini, user_id harus selalu ada.
    }
}
