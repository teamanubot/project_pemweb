<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sesi extends Model
{
    use HasFactory;
    protected $table = 'sesi';
    protected $guarded = ['id'];

    /**
     * Relasi: sesi milik satu course
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Relasi: sesi diajar oleh satu pengajar (user)
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * Relasi: sesi memiliki banyak modul
     */
    public function modules(): HasMany
    {
        return $this->hasMany(Module::class);
    }

    /**
     * Relasi: sesi memiliki banyak kuis
     */
    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class);
    }

    /**
     * Relasi: sesi memiliki banyak absensi
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }
}
