<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdmUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Administrador',
            'email' => 'admin@teste.com',
            'phone' => fake()->phoneNumber(),
            'cpf' => fake()->cpf(false),
            'password' => Hash::make('123456'),
            'is_admin' => true,
        ]);
    }
}
