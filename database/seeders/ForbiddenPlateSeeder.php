<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ForbiddenPlateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plates = [];

        // Spesifiki gadaganlar
        $specific = ['0000', '0001', '1000', '6666', '0013'];
        foreach ($specific as $num) {
            $plates[] = ['number' => $num, 'reason' => 'Ätiýaçlyk'];
        }

        // 3 birmeňzeş san (XXXY we XYYY)
        for ($d = 0; $d <= 9; $d++) {
            for ($o = 0; $o <= 9; $o++) {
                if ($d === $o)
                    continue;
                $xxxy = str_pad($d, 1) . str_pad($d, 1) . str_pad($d, 1) . $o;
                $xyyy = $o . str_pad($d, 1) . str_pad($d, 1) . str_pad($d, 1);
                if (!in_array($xxxy, $specific)) {
                    $plates[] = ['number' => $xxxy, 'reason' => '3 birmeňzeş san'];
                }
                if (!in_array($xyyy, $specific)) {
                    $plates[] = ['number' => $xyyy, 'reason' => '3 birmeňzeş san'];
                }
            }
        }

        // Dublikatlary aýyr
        $unique = collect($plates)->unique('number')->values()->toArray();
        DB::table('forbidden_plates')->insert($unique);
    }
}
