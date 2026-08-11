<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlateTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('plate_types')->insert([
            ['name' => 'Mugt Nomer', 'base_price' => 0.00],
            ['name' => 'Premium Nomer', 'base_price' => 300.00],
            ['name' => 'Yzygiderli Nomer', 'base_price' => 800.00],
            ['name' => 'VIP Nomer', 'base_price' => 1000.00],
        ]);
    }
}
