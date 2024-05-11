<?php

namespace Modules\Cuti\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Cuti\Models\JenisCuti;
class CutiDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        JenisCuti::firstOrCreate([
            'jenis_cuti' => 'Cuti Tahunan'
        ]);
        JenisCuti::firstOrCreate([
            'jenis_cuti' => 'Cuti Sakit'
        ]);
        JenisCuti::firstOrCreate([
            'jenis_cuti' => 'Cuti Karena Alasan Penting'
        ]);
        JenisCuti::firstOrCreate([
            'jenis_cuti' => 'Cuti Besar'
        ]);
        JenisCuti::firstOrCreate([
            'jenis_cuti' => 'Cuti Melahirkan'
        ]);
        JenisCuti::firstOrCreate([
            'jenis_cuti' => 'Cuti Diluar Tanggungan Negara'
        ]);
        // $this->call([]);
    }
}
