<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminAccountSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('admin_accounts')->updateOrInsert(
            ['email' => 'basilfulgencio@gmail.com'],
            [
                'name'       => 'Admin',
                'email'      => 'basilfulgencio@gmail.com',
                'password'   => Hash::make('Admin@1234'),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
