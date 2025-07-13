<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Module extends Model
{
    use HasFactory;
    protected $table = 'modules';
    protected $guarded = ['id'];

    /**
     * Relasi: modul milik satu sesi
     */
    public function sesi(): BelongsTo
    {
        return $this->belongsTo(Sesi::class);
    }
}
