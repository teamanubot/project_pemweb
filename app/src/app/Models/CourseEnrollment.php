<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CourseEnrollment extends Model
{
    use HasFactory;
    protected $table = 'course_enrollments';
    protected $guarded = ['id'];

    /**
     * Relasi: enrollment dimiliki oleh satu user
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: enrollment terkait satu course
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Relasi: satu enrollment memiliki satu transaksi pembayaran
     */
    public function paymentTransaction(): HasOne
    {
        return $this->hasOne(PaymentTransaction::class);
    }
}
