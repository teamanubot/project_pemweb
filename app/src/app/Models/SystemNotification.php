<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SystemNotification extends Model
{
    use HasFactory;
    protected $table = 'system_notification';
    protected $guarded = ['id'];

    /**
     * Relasi: notifikasi dikirim ke user
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
