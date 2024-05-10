<?php

namespace Modules\Pegawai\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Pegawai\Models\ModelPegawai;
use App\Models\User;
use Modules\Role\Models\Role;
class PegawaiDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                "nama" => "ROSAIL AKHYARI P, S.STP, M.Si",
                "nip" => "19800629 199810 1 001",
                "jabatan" => "Kepala BPKAD"
            ],
            [
                "nama" => "Ir. Putri Reno Sari, M.Si",
                "nip" => "19660602 199203 2 005",
                "jabatan" => "Sekretaris BPKAD"
            ],
            [
                "nama" => "Yunasri, SE, M.Si",
                "nip" => "19650103 199503 1 007",
                "jabatan" => "Fungsional AKPD"
            ],
            [
                "nama" => "Bima Adhitama, S.STP, M.M",
                "nip" => "19851029 200312 1 001",
                "jabatan" => "Fungsional AKPD"
            ],
            [
                "nama" => "Silvia Delvina, SE. Ak, M.Si",
                "nip" => "19730618 199303 2 001",
                "jabatan" => "Analis SDM Aparatur Ahli Muda"
            ],
            [
                "nama" => "Desti Elni, SE, MM",
                "nip" => "19761204 199703 2 003",
                "jabatan" => "Kasubag Keuangan dan Program"
            ],
            [
                "nama" => "Martinus, SE",
                "nip" => "19750315 201001 1 012",
                "jabatan" => "Pelaksana pada Sekretariat"
            ],
            [
                "nama" => "Ike Roza Mardian, SE, M.Ak",
                "nip" => "19831225 200901 2 002",
                "jabatan" => "Pelaksana pada Sekretariat"
            ],
            [
                "nama" => "Almasriva Aini, SE",
                "nip" => "19871213 201503 2 004",
                "jabatan" => "Pelaksana pada Sekretariat"
            ],
            [
                "nama" => "Utami Yulthaharce, A.Md",
                "nip" => "19820706 200604 2 012",
                "jabatan" => "Pelaksana pada Sekretariat"
            ],
            [
                "nama" => "Leni Marlina, A.Md",
                "nip" => "19850411 201101 2 001",
                "jabatan" => "Pelaksana pada Sekretariat"
            ],
            [
                "nama" => "Hendrizal, S.Tr.Ak",
                "nip" => "19830317 201101 1 003",
                "jabatan" => "Pelaksana pada Sekretariat"
            ],
            [
                "nama" => "Harmilia, A.Md",
                "nip" => "19810107 200902 2 001",
                "jabatan" => "Pelaksana pada Sekretariat"
            ],
            [
                "nama" => "Meilina Juwita, A.Md",
                "nip" => "19830518 201001 2 026",
                "jabatan" => "Pelaksana pada Sekretariat"
            ],
            [
                "nama" => "Deswita",
                "nip" => "19661203 198801 2 001",
                "jabatan" => "Pelaksana pada Sekretariat"
            ],
            [
                "nama" => "Faisal Hidayat Ardiansyah, S. STP",
                "nip" => "19970915 202008 1 001",
                "jabatan" => "Pelaksana pada Sekretariat"
            ],
            [
                "nama" => "Darwin",
                "nip" => "19680704 200701 1 008",
                "jabatan" => "Pelaksana pada Sekretariat"
            ],
            [
                "nama" => "Pesti Hidayat",
                "nip" => "19840218 201001 2 006",
                "jabatan" => "Pelaksana pada Sekretariat"
            ],
            [
                "nama" => "Rescy Herico, SE",
                "nip" => "19900412 201503 1 001",
                "jabatan" => "Pelaksana pada Sekretariat"
            ],
            [
                "nama" => "Etris DSEM, SSTP., M.Si",
                "nip" => "19781218 199912 1 001",
                "jabatan" => "Kabid. Perben. Aklap"
            ],
            [
                "nama" => "Nelda Arliza, SE, ME",
                "nip" => "19740921 200312 2 003",
                "jabatan" => "Kasubid Perbendaharaan"
            ],
            [
                "nama" => "Elgustin, SE, MM",
                "nip" => "19710815 200604 2 010",
                "jabatan" => "Kasubid Kas Daerah"
            ],
            [
                "nama" => "Erwin Rydas, SE",
                "nip" => "19690715 199102 1 002",
                "jabatan" => "Analis AKPD Ahli Muda"
            ],
            [
                "nama" => "Sulastri Endang Rukmini, SE. M.Si",
                "nip" => "19790213 200802 2 001",
                "jabatan" => "Pelaksana pada Bid. Perbend. Aklap"
            ],
            [
                "nama" => "Andri Yovianda, SE, MM",
                "nip" => "19860321 201001 1 014",
                "jabatan" => "Pelaksana pada Bid. Perbend. Aklap"
            ],
            [
                "nama" => "Yusniati Amir, SE",
                "nip" => "19691119 199303 2 005",
                "jabatan" => "Pelaksana pada Bid. Perbend. Aklap"
            ],
            [
                "nama" => "Willy Susparela, SE, MM",
                "nip" => "19790404 200312 2 005",
                "jabatan" => "Pelaksana pada Bid. Perbend. Aklap"
            ],
            [
                "nama" => "Edi Candra, SE",
                "nip" => "19780717 200604 1 007",
                "jabatan" => "Pelaksana pada Bid. Perbend. Aklap"
            ],
            [
                "nama" => "Rudi Idriansyah, SE",
                "nip" => "19850808 201001 1 024",
                "jabatan" => "Pelaksana pada Bid. Perbend. Aklap"
            ],
            [
                "nama" => "Izati, SE",
                "nip" => "19810324 201001 2 014",
                "jabatan" => "Pelaksana pada Bid. Perbend. Aklap"
            ],
            [
                "nama" => "Michelly Nugraha, A.Md",
                "nip" => "19810926 201001 2 005",
                "jabatan" => "Pelaksana pada Bid. Perbend. Aklap"
            ],
            [
                "nama" => "Nico Fernando, A.Md",
                "nip" => "19890614 201101 1 001",
                "jabatan" => "Pelaksana pada Bid. Perbend. Aklap"
            ],
            [
                "nama" => "Yuni Mariaty, A.Md",
                "nip" => "19720601 201001 2 002",
                "jabatan" => "Pelaksana pada Bid. Perbend. Aklap"
            ],
            [
                "nama" => "Feri Gusdi, A. Md",
                "nip" => "19851014 200901 1 002",
                "jabatan" => "Pelaksana pada Bid. Perbend. Aklap"
            ],
            [
                "nama" => "Faridatul Hamdia A. Md",
                "nip" => "19871102 201101 2 014",
                "jabatan" => "Pelaksana pada Bid. Perbend. Aklap"
            ],
            [
                "nama" => "Shinta Desmayenti, SE",
                "nip" => "19871228 201101 2 013",
                "jabatan" => "Pelaksana pada Bid. Perbend. Aklap"
            ],
            [
                "nama" => "Claudia Ivonne, SE",
                "nip" => "19870416 201101 2 003",
                "jabatan" => "Pelaksana pada Bid. Perbend. Aklap"
            ],
            [
                "nama" => "Ratna Dewi, S.Sos",
                "nip" => "19760618 200801 2 005",
                "jabatan" => "Pelaksana pada Bid. Perbend. Aklap"
            ],
            [
                "nama" => "Imran, S. Sos",
                "nip" => "19810328 200901 1 005",
                "jabatan" => "Pelaksana pada Bid. Perbend. Aklap"
            ],
            [
                "nama" => "Dani Endarto, SH",
                "nip" => "19791010 200604 1 009",
                "jabatan" => "Pelaksana pada Bid. Perbend. Aklap"
            ],
            [
                "nama" => "AsmaLatifa S.Tr.IP",
                "nip" => "19990619 202108 2 002",
                "jabatan" => "Pelaksana pada Bid. Perbend. Aklap"
            ],
            [
                "nama" => "Fajri Junafri Yoga, R.Tr. IP",
                "nip" => "20000602 202208 1 001",
                "jabatan" => "Pelaksana pada Bid. Perbend. Aklap"
            ],
            [
                "nama" => "M. Wahyudi Hosen, S.Pd",
                "nip" => "19910318 201403 1 001",
                "jabatan" => "Pelaksana pada Bid. Pengelolaan BMD"
            ],
            [
                "nama" => "Cecep Nugraha",
                "nip" => "19741013 201404 1 001",
                "jabatan" => "Pelaksana pada Bid. Perbend. Aklap"
            ],
            [
                "nama" => "Silviana, S.Sos, M.Si",
                "nip" => "19691213 199308 2 001",
                "jabatan" => "Kabid. Anggaran dan Pembinaan Keuangan Daerah"
            ],
            [
                "nama" => "Yessi Maisa, SE, MM",
                "nip" => "19720508 199803 2 007",
                "jabatan" => "Kasubid Anggaran I"
            ],
            [
                "nama" => "Afrizal Umari, ST, M.Si",
                "nip" => "19790420 200501 1 009",
                "jabatan" => "Kasubid Bina Evaluasi APBD Kab/Kota"
            ],
            [
                "nama" => "Yenita, SE, M.Si",
                "nip" => "19720124 199803 2 005",
                "jabatan" => "Pelaksana pada Bid. Anggaran dan Pembinaan Keuangan Daerah"
            ],
            [
                "nama" => "Budi Sauti, SE. MM",
                "nip" => "19710822 200501 1 006",
                "jabatan" => "Fungsional AKPD"
            ],
            [
                "nama" => "Wawen Satria, S. Sos, MM",
                "nip" => "19740326 199303 1 002",
                "jabatan" => "Pelaksana pada Bid. Anggaran dan Pembinaan Keuangan Daerah"
            ],
            [
                "nama" => "Riswandi, ST, M.Si",
                "nip" => "19791211 200803 1 001",
                "jabatan" => "Pelaksana pada Bid. Anggaran dan Pembinaan Keuangan Daerah"
            ],
            [
                "nama" => "Silfi Harita, SE, M.Si, Ak",
                "nip" => "19780103 200003 2 003",
                "jabatan" => "Pelaksana pada Bid. Anggaran dan Pembinaan Keuangan Daerah"
            ],
            [
                "nama" => "Rita Azwani, SE. M.Si",
                "nip" => "19830829 200901 2 002",
                "jabatan" => "Pelaksana pada Bid. Anggaran dan Pembinaan Keuangan Daerah"
            ],
            [
                "nama" => "Hendria Putra Sirpiat, S.Kom",
                "nip" => "19850625 201001 1 010",
                "jabatan" => "Pelaksana pada Bid. Anggaran dan Pembinaan Keuangan Daerah"
            ],
            [
                "nama" => "Armin",
                "nip" => "19721130 199403 1 001",
                "jabatan" => "Pelaksana pada Bid. Anggaran dan Pembinaan Keuangan Daerah"
            ],
            [
                "nama" => "My Happy Flowerina, S.STP, M.A.P",
                "nip" => "19931008 201507 2 001",
                "jabatan" => "Pelaksana pada Bid. Anggaran dan Pembinaan Keuangan Daerah"
            ],
            [
                "nama" => "Ivani, SE. MM",
                "nip" => "19800222 201101 2 001",
                "jabatan" => "Pelaksana pada Bid. Anggaran dan Pembinaan Keuangan Daerah"
            ],
            [
                "nama" => "Nefo Apri Aza S.Kom",
                "nip" => "19840429 201001 1 019",
                "jabatan" => "Pelaksana pada Bid. Anggaran dan Pembinaan Keuangan Daerah"
            ],
            [
                "nama" => "Debi Andriyani, Amd",
                "nip" => "19730206 201101 2 001",
                "jabatan" => "Pelaksana pada Bid. Anggaran dan Pembinaan Keuangan Daerah"
            ],
            [
                "nama" => "Don Vedro, SE",
                "nip" => "19850315 201001 1 017",
                "jabatan" => "Pelaksana pada Bid. Anggaran dan Pembinaan Keuangan Daerah"
            ],
            [
                "nama" => "Rahmat Hasayuni Saputra, S.Kom",
                "nip" => "19820629 201001 1 018",
                "jabatan" => "Pelaksana pada Bid. Anggaran dan Pembinaan Keuangan Daerah"
            ],
            [
                "nama" => "Donna Ariyanti, A.Md",
                "nip" => "19771115 201001 2 004",
                "jabatan" => "Pelaksana pada Bid. Anggaran dan Pembinaan Keuangan Daerah"
            ],
            [
                "nama" => "Yanti, A.Md",
                "nip" => "19840816 201001 2 027",
                "jabatan" => "Pelaksana pada Bid. Anggaran dan Pembinaan Keuangan Daerah"
            ],
            [
                "nama" => "Dina El rahmi, S.A.P",
                "nip" => "19930307 202012 2 022",
                "jabatan" => "Pelaksana pada Bid. Anggaran dan Pembinaan Keuangan Daerah"
            ],
            [
                "nama" => "Rahim Ihsan Agpar Tanjung, S,Tr.IP",
                "nip" => "19971029 202208 1 001",
                "jabatan" => "Pelaksana pada Bid. Anggaran dan Pembinaan Keuangan Daerah"
            ],
            [
                "nama" => "Badriman",
                "nip" => "19730107 200801 1 002",
                "jabatan" => "Pelaksana pada Bid. Anggaran dan Pembinaan Keuangan Daerah"
            ],
            [
                "nama" => "Desyana Putri, A.Md",
                "nip" => "19921230 202012 2 012",
                "jabatan" => "Pelaksana pada Bid. Anggaran dan Pembinaan Keuangan Daerah"
            ],
            [
                "nama" => "Budiyarma,S.Sos.M.Si",
                "nip" => "19730828 199803 2 010",
                "jabatan" => "Kabid. Pengelolaan Barang Milik Daerah"
            ],
            [
                "nama" => "Kurnilla Sofiany, SE,M.Si",
                "nip" => "19840315 200901 2 001",
                "jabatan" => "Kasubid. Pemindahtanganan dan Penghapusan"
            ],
            [
                "nama" => "Ir. Zainar",
                "nip" => "19671016 199202 2 003",
                "jabatan" => "Kasubid. Kebutuhan dan Penganggaran"
            ],
            [
                "nama" => "Melky Eka Saputra, SE,M.Si",
                "nip" => "19840521 200901 1 002",
                "jabatan" => "Analis AKPD Ahli Muda"
            ],
            [
                "nama" => "Rivi Hamdani, S,Kom, M.Ak",
                "nip" => "19770903 200502 1 002",
                "jabatan" => "Pelaksana pada Bid. Pengelolaan BMD"
            ],
            [
                "nama" => "Herliliana Lubis, SH, MM",
                "nip" => "19801023 200604 2 007",
                "jabatan" => "Pelaksana pada Bid. Pengelolaan BMD"
            ],
            [
                "nama" => "Arniyati, SE, M.Si",
                "nip" => "19760726 201001 2 008",
                "jabatan" => "Pelaksana pada Bid. Pengelolaan BMD"
            ],
            [
                "nama" => "Vera Ira Susanti, S.Kom",
                "nip" => "19780603 201001 2 006",
                "jabatan" => "Pelaksana pada Bid. Pengelolaan BMD"
            ],
            [
                "nama" => "Taufik, S.Sos",
                "nip" => "19670221 200604 1 003",
                "jabatan" => "Pelaksana pada Bid. Pengelolaan BMD"
            ],
            [
                "nama" => "Maryones, S.Ap",
                "nip" => "19750310 200801 1 004",
                "jabatan" => "Pelaksana pada Bid. Pengelolaan BMD"
            ],
            [
                "nama" => "Nurmi Yetti, S.Pd",
                "nip" => "19801202 200801 2 002",
                "jabatan" => "Pelaksana pada Bid. Pengelolaan BMD"
            ],
            [
                "nama" => "Azriani",
                "nip" => "19780613 200904 2 007",
                "jabatan" => "Pelaksana pada Bid. Pengelolaan BMD"
            ],
            [
                "nama" => "Indriyanto",
                "nip" => "19800920 200904 2 013",
                "jabatan" => "Pelaksana pada Bid. Pengelolaan BMD"
            ],
            [
                "nama" => "Wulan Angraini, A.Md",
                "nip" => "19930721 202012 2 018",
                "jabatan" => "Pelaksana pada Bid. Pengelolaan BMD"
            ],
            [
                "nama" => "Yuli, A.Md",
                "nip" => "19880624 201101 2 017",
                "jabatan" => "Pelaksana pada Bid. Pengelolaan BMD"
            ],
            [
                "nama" => "Alma Novita, S.Pd",
                "nip" => "19911222 201101 2 006",
                "jabatan" => "Pelaksana pada Bid. Pengelolaan BMD"
            ],
            [
                "nama" => "Edi Cahyadi, A.Md",
                "nip" => "19830120 201001 2 020",
                "jabatan" => "Pelaksana pada Bid. Pengelolaan BMD"
            ],
            [
                "nama" => "Ike Nurliah, A.Md",
                "nip" => "19750601 201001 2 003",
                "jabatan" => "Pelaksana pada Bid. Pengelolaan BMD"
            ],
            [
                "nama" => "Mia Kurnia, S.Pd",
                "nip" => "19820301 201101 2 002",
                "jabatan" => "Pelaksana pada Bid. Pengelolaan BMD"
            ],
            [
                "nama" => "Maulana Dini",
                "nip" => "19780825 200801 2 002",
                "jabatan" => "Pelaksana pada Bid. Pengelolaan BMD"
            ],
            [
                "nama" => "Susi Apriani, S.Pd",
                "nip" => "19890309 201101 2 009",
                "jabatan" => "Pelaksana pada Bid. Pengelolaan BMD"
            ],
            [
                "nama" => "Rimawanti, A.Md",
                "nip" => "19901025 201101 2 001",
                "jabatan" => "Pelaksana pada Bid. Pengelolaan BMD"
            ],
            [
                "nama" => "Pety Prima", 
                "nip" => "19800507 201101 1 001",
                "jabatan" => "Pelaksana pada Bid. Pengelolaan BMD"
            ],
            [
                "nama" => "Fahrodi",
                "nip" => "19950105 202208 1 001",
                "jabatan" => "Pelaksana pada Bid. Pengelolaan BMD"
            ]
        ];
        $jabatan = [
            ["id" => 1, "nama_jabatan" => "Kepala BPKAD"],
            ["id" => 2, "nama_jabatan" => "Sekretaris BPKAD"],
            ["id" => 3, "nama_jabatan" => "Fungsional AKPD"],
            ["id" => 4, "nama_jabatan" => "Analis SDM Aparatur Ahli Muda"],
            ["id" => 5, "nama_jabatan" => "Kasubag Keuangan dan Program"],
            ["id" => 6, "nama_jabatan" => "Pelaksana pada Sekretariat"],
            ["id" => 7, "nama_jabatan" => "Kabid. Perben. Aklap"],
            ["id" => 8, "nama_jabatan" => "Kasubid Perbendaharaan"],
            ["id" => 9, "nama_jabatan" => "Kasubid Kas Daerah"],
            ["id" => 10, "nama_jabatan" => "Analis AKPD Ahli Muda"],
            ["id" => 11, "nama_jabatan" => "Pelaksana pada Bid. Perbend. Aklap"],
            ["id" => 12, "nama_jabatan" => "Kabid. Anggaran dan Pembinaan Keuangan Daerah"],
            ["id" => 13, "nama_jabatan" => "Kasubid Anggaran I"],
            ["id" => 14, "nama_jabatan" => "Kasubid Bina Evaluasi APBD Kab/Kota"],
            ["id" => 15, "nama_jabatan" => "Pelaksana pada Bid. Anggaran dan Pembinaan Keuangan Daerah"],
            ["id" => 16, "nama_jabatan" => "Kabid. Pengelolaan Barang Milik Daerah"],
            ["id" => 17, "nama_jabatan" => "Kasubid. Pemindahtanganan dan Penghapusan"],
            ["id" => 18, "nama_jabatan" => "Kasubid. Kebutuhan dan Penganggaran"],
            ["id" => 19, "nama_jabatan" => "Pelaksana pada Bid. Pengelolaan BMD"]
        ];
        $pegawai = collect($data)->map(function($item)use ($jabatan){
            $nip = str_replace(' ', '', $item['nip']);
            $tahun = substr($nip, 0, 4);
            $bulan = substr($nip, 4, 2);
            $tanggal = substr($nip, 6, 2);

            return [
                "id_jabatan_organisasi"=>collect($jabatan)->firstWhere('nama_jabatan',$item['jabatan'])?collect($jabatan)->firstWhere('nama_jabatan',$item['jabatan'])['id']:100,
                "nomor_induk_pegawai"=> $nip,
                'nama'=> $item['nama'],
                'tgl_lahir'=> $tahun . "-" . $bulan . "-" . $tanggal,
                'id_jenis_kelamin' => substr($nip, 14, 1),
                'id_user_create'=>1
            ];
        });
        ModelPegawai::insert($pegawai->toArray());
        $role = Role::firstOrCreate([
            'name' => 'pegawai'
        ]);
        foreach ($pegawai as $key => $value) {
            $user = User::firstOrCreate([
                'username' => $value['nomor_induk_pegawai'],
                ],[
                'name'	=> $value['nama'],
                'email'	=> $value['nomor_induk_pegawai'] . '@sumbarprov.go.id',
                'password'	=> bcrypt( $value['nomor_induk_pegawai'])
            ]);
            $user->assignRole($role->name);
        }
        // $this->call([]);
    }
}
