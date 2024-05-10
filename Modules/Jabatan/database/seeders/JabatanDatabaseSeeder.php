<?php

namespace Modules\Jabatan\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Jabatan\Models\JabatanOrganisasi;
class JabatanDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jabatanOrg = [
            [
                'nama_jabatan'=>'Kepala BPKAD'
            ],
            [
                'nama_jabatan'=>'Sekretaris BPKAD'
            ],
            [
                'nama_jabatan'=>'Funsional AKPD'
            ],
            [
                'nama_jabatan'=>'Analis SDM Aparatur Ahli Muda'
            ],
            [
                'nama_jabatan'=>'Kasubag Keuangan dan Program'
            ],
            [
                'nama_jabatan'=>'Pelaksana pada Sekretariat'
            ],
            [
                'nama_jabatan'=>'Kabid. Perben. Aklap'
            ],
            [
                'nama_jabatan'=>'Kasubid  Perbendaharaan'
            ],
            [
                'nama_jabatan'=>'Kasubid  Kas Daerah'
            ],
            [
                'nama_jabatan'=>'Analis AKPD Ahli Muda'
            ],
            [
                'nama_jabatan'=>'Pelaksana pada Bid. Perbend. Aklap'
            ],
            [
                'nama_jabatan'=>'Kabid. Anggaran dan Pembinaan Keuangan Daerah'
            ],
            [
                'nama_jabatan'=>'Kasubid Anggaran I'
            ],
            [
                'nama_jabatan'=>'Kasubid Bina Evaluasi APBD Kab/Kota'
            ],
            [
                'nama_jabatan'=>'Pelaksana pada  Bid. Anggaran dan Pembinaan Keuangan Daerah'
            ],
            [
                'nama_jabatan'=>'Kabid. Pengelolaan Barang Milik Daerah'
            ],
            [
                'nama_jabatan'=>'Kasubid. Pemindahtanganan dan Penghapusan'
            ],
            [
                'nama_jabatan'=>'Kasubid. Kebutuhan dan Penganggaran'
            ],
            [
                'nama_jabatan'=>'Pelaksana pada Bid. Pengelolaan BMD'
            ],
        ];
        JabatanOrganisasi::insert($jabatanOrg);
    }
}
