<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentsTableSeeder extends Seeder {
    public function run(): void {
        DB::table('departments')->updateOrInsert(
            ['id' => 1],
            ['name' => 'Akademik', 'description' => 'Departemen akademik', 'created_at' => now(), 'updated_at' => now()]
        );

        DB::table('departments')->updateOrInsert(
            ['id' => 2],
            ['name' => 'HR & Operasional', 'description' => 'Departemen HR & Operasional', 'created_at' => now(), 'updated_at' => now()]
        );

        DB::table('departments')->updateOrInsert(
            ['id' => 3],
            ['name' => 'Mahasiswa', 'description' => 'Departemen Mahasiswa', 'created_at' => now(), 'updated_at' => now()]
        );
    }
}
