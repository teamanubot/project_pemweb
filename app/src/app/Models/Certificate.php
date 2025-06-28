<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Certificate extends Model
{
    use HasFactory;
    protected $table = 'certificates';
    protected $guarded = ['id'];

    /**
     * Relasi: sertifikat milik user (peserta)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: sertifikat terkait dengan course
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
