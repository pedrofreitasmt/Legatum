<?php

namespace Database\Seeders;

use App\Models\Testament;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdmUserSeeder::class,
        ]);

        Testament::factory(15)->create();
    }
}
