<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('regions')->insert([
            ['name' => 'Arkadag şäheri', 'code' => 'AK'],
            ['name' => 'Aşgabat şäheri', 'code' => 'AG'],
            ['name' => 'Ahal welaýaty', 'code' => 'AH'],
            ['name' => 'Balkan welaýaty', 'code' => 'BN'],
            ['name' => 'Daşoguz welaýaty', 'code' => 'DZ'],
            ['name' => 'Lebap welaýaty', 'code' => 'LB'],
            ['name' => 'Mary welaýaty', 'code' => 'MR'],
        ]);
    }
}
