<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SystemNotification;
use App\Models\User;

class SystemNotificationsTableSeeder extends Seeder
{
    public function run()
    {
        SystemNotification::create([
            'user_id' => User::first()->id,
            'type' => 'email',
            'subject' => 'Notifikasi awal',
            'message' => 'Selamat datang!',
            'status' => 'sent',
            'sent_at' => now()
        ]);
    }
}
