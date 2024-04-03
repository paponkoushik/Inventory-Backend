<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run() {
        User::query()->insert([
            [
                'name' => 'Koushik',
                'email' => 'koushik@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('123456'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Papon',
                'email' => 'Papon@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('123456'),
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
