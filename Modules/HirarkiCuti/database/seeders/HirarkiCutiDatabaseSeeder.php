<?php

namespace Modules\HirarkiCuti\Database\Seeders;

use Illuminate\Database\Seeder;
use  Modules\Cuti\Models\Hirarki;
use  Modules\Cuti\Models\DetailHirarki;
use  Modules\Cuti\Models\HirarkiHasPegawai;

class HirarkiCutiDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Hirarki::firstOrCreate([
            'nama_hirarki' => 'Level Staf Kasubid Perbendaharaan'
        ]);
        Hirarki::firstOrCreate([
            'nama_hirarki' => 'Level Kasubid Bidang Perben Aklap'
        ]);

        DetailHirarki::create([
            'id_hirarki' =>1,
            'urutan'=>1,
            'id_pegawai'=>21,
        ]);
        DetailHirarki::create([
            'id_hirarki' =>1,
            'urutan'=>2,
            'id_pegawai'=>20,
        ]);
        DetailHirarki::create([
            'id_hirarki' =>2,
            'urutan'=>1,
            'id_pegawai'=>20,
        ]);

        DetailHirarki::create([
            'id_hirarki' =>2,
            'urutan'=>2,
            'id_pegawai'=>1,
        ]);
        HirarkiHasPegawai::create([
            'id_hirarki' =>1,
            'id_pegawai'=>32,
        ]);
        HirarkiHasPegawai::create([
            'id_hirarki' =>2,
            'id_pegawai'=>21,
        ]);
        // $this->call([]);
    }
}
