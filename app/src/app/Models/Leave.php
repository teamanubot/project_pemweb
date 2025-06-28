<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Leave extends Model
{
    use HasFactory;
    protected $table = 'leaves';
    protected $guarded = ['id'];

    /**
     * Relasi: cuti milik user (pengaju cuti)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
