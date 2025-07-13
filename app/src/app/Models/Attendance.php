<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    use HasFactory;
    protected $table = 'attendances';
    protected $guarded = ['id'];

    /**
     * Relasi: absensi milik user
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: absensi milik sesi (jika berkaitan dengan sesi)
     */
    public function session(): BelongsTo
    {
        return $this->belongsTo(Sesi::class);
    }
}
