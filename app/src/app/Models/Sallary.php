<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sallary extends Model
{
    use HasFactory;
    protected $table = 'sallaries'; // sesuai nama tabel di Excel
    protected $guarded = ['id'];

    /**
     * Relasi: gaji milik user (pegawai/pengajar)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
