<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchOffice extends Model
{
    use HasFactory;
    protected $table = 'branch_offices';
    protected $guarded = ['id'];

    /**
     * Contoh relasi (jika suatu saat sesi dikaitkan dengan cabang)
     * public function sesi(): HasMany
     * {
     *     return $this->hasMany(Sesi::class);
     * }
     */
}
