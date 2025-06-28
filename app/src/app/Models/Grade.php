<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Grade extends Model
{
    use HasFactory;
    protected $table = 'grades';
    protected $guarded = ['id'];

    /**
     * Relasi: nilai milik user (siswa)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: nilai terkait dengan course
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
