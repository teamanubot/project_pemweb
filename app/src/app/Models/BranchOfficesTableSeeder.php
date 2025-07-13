<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BranchOffice;

class BranchOfficesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BranchOffice::insert([
            [
                'name' => 'UEU Jakarta Bootcamp Center',
                'address' => 'Jl. Sudirman No. 21, Jakarta Pusat',
                'capacity' => 120,
                'contact_person_name' => 'Dewi Santika',
                'contact_person_phone' => '081234567890',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'UEU Bandung Coding Hub',
                'address' => 'Jl. Dago No. 45, Bandung',
                'capacity' => 90,
                'contact_person_name' => 'Agus Pratama',
                'contact_person_phone' => '081298765432',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'UEU Surabaya Tech Space',
                'address' => 'Jl. Basuki Rahmat No. 10, Surabaya',
                'capacity' => 100,
                'contact_person_name' => 'Lina Rahayu',
                'contact_person_phone' => '082112345678',
                'is_active' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
