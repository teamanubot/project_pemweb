<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollSetting extends Model
{
    use HasFactory;
    protected $table = 'payroll_settings';
    protected $guarded = ['id'];

    // Tidak ada relasi langsung berdasarkan file Excel
}
