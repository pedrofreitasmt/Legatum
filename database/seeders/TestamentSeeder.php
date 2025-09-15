<?php

namespace Database\Seeders;

use App\Models\Testament;
use Illuminate\Database\Seeder;

class TestamentSeeder extends Seeder
{
    public function run(): void
    {
        Testament::factory(10)->create();
    }
}
