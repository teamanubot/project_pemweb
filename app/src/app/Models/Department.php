<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    use HasFactory;
    // Nama tabel
    protected $table = 'departments';

    // Kolom yang dilindungi (id auto increment)
    protected $guarded = ['id'];

    /**
     * Relasi: satu departemen bisa memiliki banyak user
     * (Diasumsikan ada kolom `department_id` di tabel `users`)
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the description attribute (optional accessor if needed).
     */
    public function getDescriptionAttribute(): ?string
    {
        return $this->attributes['description'] ?? null;
    }
}
