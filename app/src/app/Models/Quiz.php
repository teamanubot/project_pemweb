<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quiz extends Model
{
    use HasFactory;
    protected $table = 'quizzes';
    protected $guarded = ['id'];

    /**
     * Relasi: kuis milik sesi (opsional)
     */
    public function sesi(): BelongsTo
    {
        return $this->belongsTo(Sesi::class);
    }

    /**
     * Relasi: kuis milik course
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Relasi: kuis memiliki banyak submission
     */
    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class);
    }
}
