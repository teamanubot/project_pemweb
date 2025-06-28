<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;
    protected $table = 'course';
    protected $guarded = ['id'];

    /**
     * Relasi: course memiliki banyak sesi
     */
    public function sesi(): HasMany
    {
        return $this->hasMany(Sesi::class);
    }

    /**
     * Relasi: course memiliki banyak silabus
     */
    public function syllabi(): HasMany
    {
        return $this->hasMany(Syllabus::class);
    }

    /**
     * Relasi: course memiliki banyak enrollment
     */
    public function enrollments(): HasMany
    {
        return $this->hasMany(CourseEnrollment::class);
    }

    /**
     * Relasi: course memiliki banyak kuis
     */
    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class);
    }

    /**
     * Relasi: course memiliki banyak nilai
     */
    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class);
    }

    /**
     * Relasi: course memiliki banyak sertifikat
     */
    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }
}
