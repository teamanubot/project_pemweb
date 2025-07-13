<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyProfileSetting extends Model
{
    use HasFactory;
    protected $table = 'company_profile_settings';
    protected $guarded = ['id'];

    // Tidak ada relasi langsung berdasarkan struktur tabel
}
