<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Submission extends Model
{
    use HasFactory;
    protected $table = 'submissions';
    protected $guarded = ['id'];

    /**
     * Relasi: submission milik kuis
     */
    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    /**
     * Relasi: submission dikirim oleh user
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
