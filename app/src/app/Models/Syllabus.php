<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Syllabus extends Model
{
    use HasFactory;
    protected $table = 'syllabi'; // bentuk plural tidak biasa, tapi dari Excel memang ini

    protected $guarded = ['id'];

    /**
     * Relasi: silabus milik satu course
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
