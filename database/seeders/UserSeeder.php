<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@teste.com',
            'password' => bcrypt('123456'),
            'cpf' => '12345678901',
            'phone' => '11999999999',
            'email_verified_at' => now(),
        ])->assignRole('Super Admin');

        User::factory(5)->create();
    }
}
