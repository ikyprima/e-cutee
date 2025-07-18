<?php

namespace Modules\Cuti\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;
use Modules\Cuti\Models\AjukanCuti;
use Modules\Pegawai\Models\Pegawai;
use Illuminate\Support\Facades\Auth;

use Elibyy\TCPDF\Facades\TCPDF;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Style\Image as ImageStyle;
use PhpOffice\PhpWord\PhpWord;
use Carbon\Carbon;
use Storage;
use Modules\Cuti\Models\JenisCuti;
use Modules\Cuti\Models\DokumenOutput;  
use Image;
class CutiController extends Controller
{
    /**
     * Display a listing of the resource.
     */  

    protected $tahunSekarang;

    public function __construct()
    {
        $this->tahunSekarang = Carbon::now()->year;
    }

    public function index(Request $request)
    {
        if( Auth::user()->hasAnyRole(['admin','pimpinan'])){

            
            if($request->has('tahun')){
                $tahun =  $request->tahun;
            }else{
                $tahun =  $this->tahunSekarang;
            }

            $dataCuti = AjukanCuti::with('dokumenOutput','pegawai.jabatanOrganisasi','jenisCuti','detailTanggal','detailPersetujuan.pegawai')
            ->whereYear('created_at',  $tahun )
            ->orderBy('created_at', 'desc')
            ->paginate(10)->through(function($item){

                if($item->status == 0){
                    $stat = 'Menunggu Persetujuan';
                    $class = 'text-blue-600 bg-blue-200';
                }elseif($item->status == 1){
                    $stat = 'Disetujui';
                    $class = 'text-green-600 bg-green-200';
                }
                elseif($item->status == 2){
                    $stat = 'Ditolak';
                    $class = 'text-red-600 bg-red-200';
                }
                $item['stringstat'] =[
                    'nama'=>$stat,
                    'kode'=> $item->status,
                    'class'=> $class
                ];

                $item['lampiran']= $item->detailLampiran;
                return $item;
            });
            
            return Inertia::render('Cuti/ListPengajuanCuti',[
                'dataCuti' => $dataCuti
            ]);
        
        }else{
    
            
            
            $pegawai = Pegawai::where('nomor_induk_pegawai',Auth::user()->username)->first();
            $id_pegawai =  $pegawai->id;
            $dataCuti = AjukanCuti::with('jenisCuti')
            ->where('id_pegawai',$id_pegawai)
            ->orderBy('created_at', 'desc')
            ->with('dokumenOutput','pegawai.jabatanOrganisasi','detailTanggal','detailPersetujuan.pegawai')
            ->paginate(10)
            ->through(function($item){
                $tanggal = $item->detailTanggal->map(function($item){
                    return [
                    'title'=>$item->title,
                    'date'=>$item->tgl,
                    'color'=>$item->color
                    ];
                });
                    if($item->status == 0){
                        $stat = 'Menunggu Persetujuan';
                        $class = 'text-blue-600 bg-blue-200';
                    }elseif($item->status == 1){
                        $stat = 'Disetujui';
                        $class = 'text-green-600 bg-green-200';
                    }
                    elseif($item->status == 2){
                        $stat = 'Ditolak';
                        $class = 'text-red-600 bg-red-200';
                    }
                    $item['stringstat'] =[
                        'nama'=>$stat,
                        'kode'=> $item->status,
                        'class'=> $class
                    ];
                    $item['tanggal'] = $tanggal;
                    $item['lampiran'] = $item->detailLampiran;

                    return $item;
                });
            
            
            return Inertia::render('Cuti/Index',[
                'dataCuti' => $dataCuti
            ]);
        }   
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cuti::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('cuti::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('cuti::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }

    function sisaCuti(Request $request){
        $tahun = Carbon::now()->year;
        $tahunlalu = Carbon::now()->year-1;
        $master = JenisCuti::all();
        $pegawai = Pegawai::where('id',$request->id)->with('dataAjukanCuti.detailTanggal','sisaCuti2024')->first();
        $data = collect( [
            'nip'=>$pegawai->nomor_induk_pegawai,
            'nama'=>$pegawai->nama,
        ]);

        foreach ($master as $key => $value) {
            // $jumlah =  $pegawai->dataAjukanCuti->where('id_jenis_cuti',$value['id'])->where('status',1);
            $jumlah = $pegawai->dataAjukanCuti->filter(function($item) use ($tahun, $value){
                return Carbon::parse($item['created_at'])->year == $tahun && $item->id_jenis_cuti == $value['id'] && $item->status == 1;
            })
            ->sum(function ($item) {
                return count($item->detailTanggal);
            }); 
            $data->put(strtolower(str_replace(' ', '_', $value['jenis_cuti'])), (string)$jumlah);
        }

        $cuti_tahunan_lalu = $pegawai->dataAjukanCuti->filter(function($item) use ($tahunlalu, $value){
            return Carbon::parse($item['created_at'])->year == $tahunlalu && $item->id_jenis_cuti == 1 && $item->status == 1;
        })
        ->sum(function ($item) {
            return count($item->detailTanggal);
        }); 

        if ($tahun == 2024) {
            $dasar = $pegawai->sisaCuti2024?$pegawai->sisaCuti2024->sisa_cuti:12 - $cuti_tahunan_lalu;
            $cutitahunsekarang = $dasar - (int) $data['cuti_tahunan'] ;
            $sisa_cuti_tahun_lalu = 0  ;
            $sisacuti = $dasar - (int) $data['cuti_tahunan'] ;
        }else{
            $cutitahunanlalu = 12 - $cuti_tahunan_lalu;
            $cutitahunsekarang = 12 - (int) $data['cuti_tahunan'];
            $sisa_cuti_tahun_lalu = $cutitahunanlalu > 6 ? 6 : $cutitahunanlalu  ;
            $sisacuti =  $sisa_cuti_tahun_lalu + $cutitahunsekarang;
        }
        return [
            'data_rekap'=> $data,
            'sisa_cuti_tahunan_lalu' =>$sisa_cuti_tahun_lalu,
            'sisa_cuti_tahunan_sekarang'=> $cutitahunsekarang,
            'sisa_cuti_tahunan' => $sisacuti,
            'tahun'=> $tahun,
            'tahun_lalu'=>$tahunlalu,
            // 'sisa_cuti_2024'=>$pegawai->sisaCuti2024
        ];

    }

    public function pdfBlanko(Request $request){
        
        Carbon::setLocale('id');
        $dataCuti = AjukanCuti::where('id',$request->id)->with('jenisCuti','pegawai.jabatanOrganisasi','detailTanggal','detailPersetujuan.pegawai')->first();
        
        $requestnew = new Request([
            "id" => $dataCuti->pegawai->id,
        ]);
    
        $dataRekapCuti =  $this->sisaCuti($requestnew);
        $filename   =  'blanko_'.$dataCuti->id.'_'.$dataCuti->pegawai->nomor_induk_pegawai.'.pdf';
        // $data = [
        //     'title' => 'Generate'
        // ];
    
        $pdf = new TCPDF;
        // $pdf::setHeaderCallback(function($pdf) {
            
          
        //     $pdf->SetFont('helvetica', 'B', 16);
        //     $pdf->Ln(7);
        //     $pdf->Cell(0, 15, 'Gener', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        //     $pdf->Ln(7);
        //     $pdf->SetFont('helvetica', 'B', 12);
        //     $pdf->Cell(0, 15, 'Pemerintah  ', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        //     $pdf->SetLineWidth(0.5);
        //     $pdf->Line(5,35,205,35);
        //     $pdf->SetLineWidth(0.1);
        //     $pdf->Line(5,36,205,36);


        //     });


        $pdf::SetTitle('');
        $pdf::AddPage('P','F4');
        
        // $bookos = storage_path('app/fonts/Bookos/bookmanoldstyle.ttf');
        // $bookosbold = storage_path('app/fonts/Bookos/bookmanoldstyle_bold.ttf');
        // $bookosbolditalic = storage_path('app/fonts/Bookos/bookmanoldstyle_bolditalic.ttf');
        // $bookositalic = storage_path('app/fonts/Bookos/bookmanoldstyle_italic.ttf');

        // $bookmanoldstyle = \TCPDF_FONTS::addTTFfont($bookos, 'TrueTypeUnicode', '', 32);
        // $bookmanoldstylebold = \TCPDF_FONTS::addTTFfont($bookosbold, 'TrueTypeUnicode', '', 32);
        // $pdf::SetFont($bookmanoldstyle, '', 11);
        $pdf::SetFont('times', '', 11);
        // $left = 20;
        // $top = 10000;
        // $right = 20;
        // $pdf::SetMargins($left, $top, $right);
        // Menentukan koordinat untuk teks

        $x = 130; // Koordinat X
        $y = 6; // Koordinat Y

        $tanggalSurat = Carbon::parse($dataCuti->created_at)->translatedFormat('d F Y');
        $pdf::SetXY($x, $y);
        $pdf::Cell(0, 6, "Padang, {$tanggalSurat}", 0, 1);
        $pdf::SetXY($x, 12);
        $pdf::Cell(0, 6, 'Kepada', 0, 1);
        $pdf::SetXY($x, 18);
        $pdf::MultiCell(0, 6, 'Yth. ', 0, 'L', false);
        $pdf::SetXY(139, 18);
        $pdf::MultiCell(50, 6, 'Kepala Badan Pengelola Keuangan dan Aset Daerah', 0, 'L', false);
        $lastY = $pdf::GetY();
        $pdf::SetXY(130, $lastY);
        $pdf::Cell(0, 6, 'di'  , 0, 1);
        $pdf::SetXY(139, $lastY + 6);
        $pdf::Cell(0, 6, 'Tempat', 0, 1);
        $pdf::Ln(6);
        $pdf::SetFont('times', 'B', 11);
        $pdf::Cell(190,6,'FORMULIR PERMINTAAN DAN PEMBERIAN CUTI',0, 1, 'L');
        $pdf::Cell(190,6,'I. DATA PEGAWAI',1, 1, 'L');
        $pdf::SetFont('times', '', 11);
        $pdf::Cell(40,6,'Nama',1, 0, 'L');
        $pdf::Cell(150,6,"{$dataCuti->pegawai->nama}",1, 1, 'L');
        $pdf::Cell(40,6,'Jabatan',1, 0, 'L');
        $pdf::Cell(150,6,"{$dataCuti->pegawai->jabatanOrganisasi->nama_jabatan}",1, 1, 'L');
        $pdf::Cell(40,6,'Unit Kerja',1, 0, 'L');
        $pdf::Cell(150,6,'Badan Pengelola Keuangan dan Aset Daerah',1, 1, 'L');
        $pdf::Ln(6);
        $pdf::SetFont('times', 'B', 11);
        $pdf::Cell(190,6,'II. JENIS CUTI YANG DIAMBIL',1, 1, 'L');
        $pdf::SetFont('times', '', 11);
        $pdf::Cell(60,6,'1. Cuti Tahunan',1, 0, 'L');
        $tahunan = $dataCuti->id_jenis_cuti == 1 ? '4' : '';
        $pdf::SetFont('zapfdingbats', '', 11);
        $pdf::Cell(35,6,"{$tahunan}",1, 0, 'C');
        $pdf::SetFont('times', '', 11);
        $pdf::Cell(60,6,'2. Cuti Besar',1, 0, 'L');
        $cutiBesar = $dataCuti->id_jenis_cuti == 4 ? '4' : '';
        $pdf::SetFont('zapfdingbats', '', 11);
        $pdf::Cell(35,6,"{$cutiBesar}",1, 1, 'L');
        $pdf::SetFont('times', '', 11);
        $pdf::Cell(60,6,'3. Cuti Sakit',1, 0, 'L');
        $cutiSakit = $dataCuti->id_jenis_cuti == 2 ? '4' : '';
        $pdf::SetFont('zapfdingbats', '', 11);
        $pdf::Cell(35,6,"{$cutiSakit}",1, 0, 'L');
        $pdf::SetFont('times', '', 11);
        $pdf::Cell(60,6,'4. Cuti Melahirkan',1, 0, 'L');
        $cutiMelahirkan = $dataCuti->id_jenis_cuti == 5 ? '4' : '';
        $pdf::SetFont('zapfdingbats', '', 11);
        $pdf::Cell(35,6,"{$cutiMelahirkan}",1, 1, 'L');
        $pdf::SetFont('times', '', 11);
        $pdf::Cell(60,6,'5. Cuti Karena Alasan Penting',1, 0, 'L');
        $cutiAlasanP = $dataCuti->id_jenis_cuti == 3 ? '4' : '';
        $pdf::SetFont('zapfdingbats', '', 11);
        $pdf::Cell(35,6,"{$cutiAlasanP}",1, 0, 'L');
        $pdf::SetFont('times', '', 11);
        $pdf::Cell(60,6,'6. Cuti Diluar Tanggungan Negara',1, 0, 'L');
        $cutiLtn = $dataCuti->id_jenis_cuti == 6 ? '4' : '';
        $pdf::SetFont('zapfdingbats', '', 11);
        $pdf::Cell(35,6,"{$cutiLtn}",1, 1, 'L');
        $pdf::SetFont('times', '', 11);
        $pdf::Ln(6);
        $pdf::SetFont('times', 'B', 11);
        $pdf::Cell(190,6,'III. ALASAN CUTI',1, 1, 'L');
        $pdf::SetFont('times', '', 11);
        $pdf::MultiCell(0, 6, "{$dataCuti->alasan_cuti}", 1, 'L', false);
        $pdf::Ln(6);
        $pdf::SetFont('times', 'B', 11);
        $pdf::Cell(190,6,'IV. LAMANYA CUTI',1, 1, 'L');
        $pdf::SetFont('times', '', 11);
        $pdf::Cell(40,6,'Selama',1, 0, 'L');
        $jumlahHari = count($dataCuti->detailTanggal);
        $pdf::Cell(40,6,"{$jumlahHari} Hari",1, 0, 'C');
        $pdf::Cell(40,6,'Tanggal',1, 0, 'L');
        if ($jumlahHari > 1) {
            $awal = Carbon::parse($dataCuti->detailTanggal[0]['tgl'])->translatedFormat('d F Y');
            $akhir = Carbon::parse($dataCuti->detailTanggal[$jumlahHari-1]['tgl'])->translatedFormat('d F Y');
            $tanggal =  "{$awal} s/d {$akhir}";
        }else{
            $tanggal = $dataCuti->detailTanggal[0]['tgl'];
        }
        $pdf::Cell(70,6,$tanggal,1, 1, 'C');
        $pdf::Ln(6);
        $pdf::SetFont('times', 'B', 11);
        $pdf::Cell(190,6,'V. CATATAN CUTI',1, 1, 'L');
        $pdf::SetFont('times', '', 11);
        $pdf::Cell(40,6,'1. Cuti Tahunan',1, 0, 'L');
        $pdf::Cell(50,6,$dataRekapCuti['data_rekap']['cuti_tahunan']." Hari",1, 0, 'C');
        $pdf::Cell(60,6,'2. Cuti Besar',1, 0, 'L');
        $pdf::Cell(40,6,$dataRekapCuti['data_rekap']['cuti_besar']." Hari",1, 1, 'C');
        $pdf::SetFont('times', 'B', 11);
        $pdf::Cell(25,6,'Tahun',1, 0, 'L');
        $pdf::Cell(15,6,'Jumlah',1, 0, 'C');
        $pdf::Cell(50,6,'Keterangan',1, 0, 'L');
        $pdf::SetFont('times', '', 11);
        $pdf::Cell(60,6,'3. Cuti Sakit',1, 0, 'L');
        $pdf::Cell(40,6,$dataRekapCuti['data_rekap']['cuti_sakit']." Hari",1, 1, 'C');
        $pdf::Cell(25,6,$dataRekapCuti['tahun_lalu'],1, 0, 'L');
        $pdf::Cell(15,6,$dataRekapCuti['sisa_cuti_tahunan_lalu'],1, 0, 'C');
        $pdf::Cell(50,6,'',1, 0, 'L');
        $pdf::Cell(60,6,'4. Cuti Melahirkan',1, 0, 'L');
        $pdf::Cell(40,6,$dataRekapCuti['data_rekap']['cuti_melahirkan']." Hari",1, 1, 'C');
        $pdf::Cell(25,6,$dataRekapCuti['tahun'],1, 0, 'L');
        $pdf::Cell(15,6,'12',1, 0, 'C');
        $pdf::Cell(50,6,'',1, 0, 'L');
        $pdf::Cell(60,6,'5. Cuti Karena Alasan Penting',1, 0, 'L');
        $pdf::Cell(40,6,$dataRekapCuti['data_rekap']['cuti_karena_alasan_penting']." Hari",1, 1, 'C');
        $pdf::SetFont('times', 'B', 11);
        $pdf::Cell(25,6,'Total Jumlah',1, 0, 'L');
        $jumcutitahunan = 12+(int)$dataRekapCuti['sisa_cuti_tahunan_lalu'];
        $pdf::Cell(15,6,$jumcutitahunan,1, 0, 'C');
        $sisacutitahunan = $jumcutitahunan - (int)$dataRekapCuti['data_rekap']['cuti_tahunan'];
        $pdf::Cell(50,6,"Sisa Cuti Tahunan {$sisacutitahunan} Hari",1, 0, 'L');
        $pdf::SetFont('times', '', 11);
        $pdf::Cell(60,6,'6. Cuti Diluar Tanggungan Negara',1, 0, 'L');
        $pdf::Cell(40,6,$dataRekapCuti['data_rekap']['cuti_diluar_tanggungan_negara']." Hari",1, 1, 'C');
        $pdf::Ln(6);
        $pdf::SetFont('times', 'B', 11);
        $pdf::Cell(190,6,'VI. ALAMAT SELAMA CUTI',1, 1, 'L');
        $pdf::SetFont('times', '', 11);
        $ybaris =  $pdf::GetY();
        $alamat = $dataCuti->alamat;
        $pdf::MultiCell(120, 6,$alamat, 1,'L', false);
        $lastY = $pdf::GetY();
        $tinggi = $lastY - $ybaris;
        $pdf::SetXY(130, $ybaris );
        $pdf::Cell(20,$tinggi,'Telp',1, 0, 'L');
        $pdf::Cell(50,$tinggi,$dataCuti->telp,1, 1, 'L');    
        $pdf::Ln(6);
        $pdf::SetFont('times', 'B', 11);
        $pdf::Cell(190,6,'PERTIMBANGAN ATASAN LANGSUNG **',1, 1, 'L');
        $pdf::SetFont('times', '', 11);
        $pdf::Cell(45,6,'DISETUJUI',1, 0, 'L');
        $pdf::Cell(45,6,'PERUBAHAN ***',1, 0, 'L');
        $pdf::Cell(50,6,'DITANGGUHKAN ***',1, 0, 'L');
        $pdf::Cell(50,6,'TIDAK DISETUJUI',1, 1, 'L');
        $setuju = $dataCuti->detailPersetujuan ? ($dataCuti->detailPersetujuan[0]->status == 1 ? '4' : '')  :'';
        $perubahan = $dataCuti->detailPersetujuan ? ($dataCuti->detailPersetujuan[0]->status == 3 ? '4' : '')  :'';
        $ditangguhkan = $dataCuti->detailPersetujuan ? ($dataCuti->detailPersetujuan[0]->status == 4 ? '4' : '')  :'';
        $tolak = $dataCuti->detailPersetujuan ? ($dataCuti->detailPersetujuan[0]->status == 2 ? '4' : '')  :'';
        $pdf::SetFont('zapfdingbats', '', 11);
        $pdf::Cell(45,6,$setuju,1, 0, 'C');
        $pdf::Cell(45,6,$perubahan,1, 0, 'C');
        $pdf::Cell(50,6,$ditangguhkan,1, 0, 'C');
        $pdf::Cell(50,6,$tolak,1, 1, 'C');
        $pdf::SetFont('times', '', 11);
        $keterangan = '';
        if ($dataCuti->detailPersetujuan) {
            $status = $dataCuti->detailPersetujuan[0]->status;
            switch ($status) {
                case 1:
                    $keterangan = 'Disetujui';
                    break;
                case 2:
                    $keterangan = 'Ditolak';
                    break;
                case 3:
                    $keterangan = 'Perubahan';
                    break;
                case 4:
                    $keterangan = 'Ditangguhkan';
                    break;
                default:
                    $keterangan = '';
                    break;
            }
        }
        $oleh = $status = $dataCuti->detailPersetujuan[0]->pegawai->nama;
        $tanggal = Carbon::parse($dataCuti->detailPersetujuan[0]->update_at)->translatedFormat('d F Y');
        $text = "{$keterangan} oleh {$oleh}, pada tanggal {$tanggal}";

        $jumlahttd =  count($dataCuti->detailPersetujuan);
        if ($jumlahttd > 1) {
            $stat = $dataCuti->detailPersetujuan[1]->status;
            $oleh =  $dataCuti->detailPersetujuan[1]->pegawai->nama;
            $tanggal = Carbon::parse($dataCuti->detailPersetujuan[1]->update_at)->translatedFormat('d F Y');
        }else{
            $oleh =  $dataCuti->detailPersetujuan[0]->pegawai->nama;
            $tanggal = Carbon::parse($dataCuti->detailPersetujuan[0]->update_at)->translatedFormat('d F Y');
            $stat = $dataCuti->detailPersetujuan[0]->status;
        }
        $pdf::MultiCell(190, 6,$text, 1, 'L', false);
        $pdf::Ln(6);
        $pdf::SetFont('times', 'B', 11);
        $pdf::Cell(190,6,'KEPUTUSAN PEJABAT YANG BERWENANG MEMBERIKAN CUTI **',1, 1, 'L');
        $pdf::SetFont('times', '', 11);
        $pdf::Cell(45,6,'DISETUJUI',1, 0, 'L');
        $pdf::Cell(45,6,'PERUBAHAN ***',1, 0, 'L');
        $pdf::Cell(50,6,'DITANGGUHKAN ***',1, 0, 'L');
        $pdf::Cell(50,6,'TIDAK DISETUJUI',1, 1, 'L');
        $setuju = $dataCuti->detailPersetujuan ? ($stat == 1 ? '4' : '')  :'';
        $perubahan = $dataCuti->detailPersetujuan ? ($stat == 3 ? '4' : '')  :'';
        $ditangguhkan = $dataCuti->detailPersetujuan ? ($stat == 4 ? '4' : '')  :'';
        $tolak = $dataCuti->detailPersetujuan ? ($stat == 2 ? '4' : '')  :'';
        $pdf::SetFont('zapfdingbats', '', 11);
        $pdf::Cell(45,6,$setuju,1, 0, 'C');
        $pdf::Cell(45,6,$perubahan,1, 0, 'C');
        $pdf::Cell(50,6,$ditangguhkan,1, 0, 'C');
        $pdf::Cell(50,6,$tolak,1, 1, 'C');
        $pdf::SetFont('times', '', 11);
        $keterangan = '';
        if ($dataCuti->detailPersetujuan) {
            // $status = $dataCuti->detailPersetujuan[1]->status;
            switch ($stat) {
                case 1:
                    $keterangan = 'Disetujui';
                    break;
                case 2:
                    $keterangan = 'Ditolak';
                    break;
                case 3:
                    $keterangan = 'Perubahan';
                    break;
                case 4:
                    $keterangan = 'Ditangguhkan';
                    break;
                default:
                    $keterangan = '';
                    break;
            }
        }
      
        $text = "{$keterangan} oleh {$oleh}, pada tanggal {$tanggal}";
        $pdf::MultiCell(190, 6,$text, 1, 'L', false);
        $pdf::Ln(6);
        
        if (!Storage::disk('local')->exists('blanko_cuti')) {
            Storage::disk('local')->makeDirectory('blanko_cuti');
        }
        
        $pdf::Output(storage_path("app/blanko_cuti/{$filename}"), 'F');

        
        DokumenOutput::create([
            'deskripsi_file'=>'blanko cuti',
            'id_cuti_ajukan' =>  $request->id,
            'path' => 'blanko_cuti',
            'nama_file' =>  $filename,
            'jenis_file' =>1
        ]);

        return response()->json([
            'status' => true,
            'nama_file'=> $filename,
            'path' => 'blanko_cuti',
            'jenis_file' =>1
        ], 200);
        
        // $html = view()->make('hirarkicuti::cetakBlanko', $data)->render();
        // $pdf::writeHTML($html, true, false, true, false, '');
        // $pdf::Output(public_path($filename), 'I');
        // return response()->download(public_path("storage/file/{$filename}"));
    }

    public function generateDocumentIzinCuti(Request $request)
    {   

        // $phpWord = new PhpWord();
        // $section = $phpWord->addSection();

        // // Tambahkan teks yang akan ditempatkan di atas gambar
        // $section->addText("Teks di atas gambar");

        // // Tambahkan gambar
        // $styleImage = array(
        //     'width' => 600,
        //     'height' => 400,
        //    'wrappingStyle' => 'behind', // Gambar tidak membungkus teks
        //     'positioning' => 'absolute', // Posisi absolut
            
        //     'position' => array('x' => 100, 'y' => 100), // Posisi gambar
        // );

        // $section->addImage(storage_path('app/asset/stempel.png'), $styleImage);

        // // Tambahkan teks di bawah gambar
        // $section->addText("Teks di bawah gambar");

        // // Simpan dokumen
        // $filename = 'example.docx';
        // $outputPath = storage_path("app/surat_cuti/{$filename}");
        // $phpWord->save($outputPath, 'Word2007');

        // return "Dokumen Word berhasil dibuat!";
        //-----------------


        $imagePath = storage_path('app/asset/stempel.png');
        $ttPath = storage_path('app/asset/tt.png');

        $ppi = 300; // Gunakan 300 untuk pencetakan berkualitas tinggi
        $cmToInches = 0.3937;
        $widthInCm = 4;
        $heightInCm = 4;

        // Konversi ukuran dari cm ke piksel
        $widthInPixels = $widthInCm * $cmToInches * $ppi;
        $heightInPixels = $heightInCm * $cmToInches * $ppi;

        // Buat gambar dengan ukuran 4 x 4 cm pada 300 PPI
        $image = Image::canvas($widthInPixels, $heightInPixels, null);
        $tt = Image::make($ttPath);
        $overlayImage = Image::make($imagePath);
        $overlayImage->resize(492, 430);
        $overlayImage->opacity(50); // Transparansi 50% 40 - 80
        $overlayImage->rotate(-4);//-4 3
        $tt->rotate(4);//-1 3
        $image->insert($tt,'top-left', 200, 150); //205 180
        $image->insert($overlayImage,'right',2,10);

        // Simpan gambar
        $outputPath = storage_path('app/asset/ttd.png');
        $image->save($outputPath);

        Carbon::setLocale('id');
        $tahun = Carbon::now()->year;
        $tahunlalu = Carbon::now()->year-1;
        $dataCuti = AjukanCuti::where('id',$request->id)->with('jenisCuti','pegawai.jabatanOrganisasi','detailTanggal','detailPersetujuan.pegawai')->first();

        // parameter
        // tahunlalu
        // tahunsekarang
        // nama
        // nip
        // pangkat
        // jabatan
        // lamahari
        // tanggalsd
        // tanggal_ttd
        // Load the template
        $jumlahHari = count($dataCuti->detailTanggal);
        $terbilangJumlahHari = $this->terbilang($jumlahHari);

        if ($jumlahHari > 1) {
            $awal = Carbon::parse($dataCuti->detailTanggal[0]['tgl'])->translatedFormat('d F Y');
            $akhir = Carbon::parse($dataCuti->detailTanggal[$jumlahHari-1]['tgl'])->translatedFormat('d F Y');
            $tanggal =  "{$awal} s.d {$akhir}";
        }else{
            $tanggal = $dataCuti->detailTanggal[0]['tgl'];
        }

        $templateProcessor = new TemplateProcessor(storage_path('app/templates/template_cuti_tahunan.docx'));
        $templateProcessor->setValue('nomor',  $request->nomor);
        $templateProcessor->setValue('tahunlalu', $tahunlalu);
        $templateProcessor->setValue('tahunsekarang', $tahun);
        $templateProcessor->setValue('nama', $dataCuti->pegawai->nama);
        $templateProcessor->setValue('nip', $this->formatNip($dataCuti->pegawai->nomor_induk_pegawai));
        $templateProcessor->setValue('pangkat', $dataCuti->pegawai->nama_pangkat);
        $templateProcessor->setValue('jabatan', $dataCuti->pegawai->jabatanOrganisasi->nama_jabatan);
        $templateProcessor->setValue('lamahari', "{$jumlahHari}({$terbilangJumlahHari})");
        $templateProcessor->setValue('tanggalsd', $tanggal);
        $templateProcessor->setValue('tanggal_ttd', Carbon::now()->translatedFormat('d F Y'));

    
        $templateProcessor->setImageValue('ttd', array(
            'path' => storage_path('app/asset/ttd.png'),
            'width' => 185,
            'height' => 160,
            'ratio' => true
        ));

        if (!Storage::disk('local')->exists('surat_cuti')) {
            Storage::disk('local')->makeDirectory('surat_cuti');
        }
        // Define the output file path
        $filename   =  'surat_izin_'.$dataCuti->id.'_'.$dataCuti->pegawai->nomor_induk_pegawai.'.docx';
        $outputPath = storage_path("app/surat_cuti/{$filename}");

        // Save the document
        $templateProcessor->saveAs($outputPath);

        DokumenOutput::create([
            'deskripsi_file'=>'surat izin cuti',
            'id_cuti_ajukan' =>  $request->id,
            'path' => 'surat_cuti',
            'nama_file' =>  $filename,
            'jenis_file' =>2
        ]);

        return response()->json([
            'status' => true,
            'nama_file'=> $filename,
            'path' => 'surat_cuti',
            'jenis_file' =>2
        ], 200);
    }
    function formatNip($input) {
        $part1 = substr($input, 0, 8);    // Mengambil bagian pertama: 19790420
        $part2 = substr($input, 8, 6);    // Mengambil bagian kedua: 200501
        $part3 = substr($input, 14, 1);   // Mengambil bagian ketiga: 1
        $part4 = substr($input, 15);      // Mengambil bagian keempat: 009
    
        // Menggabungkan semua bagian dengan spasi sebagai pemisah
        $formattedString = $part1 . ' ' . $part2 . ' ' . $part3 . ' ' . $part4;
    
        return $formattedString;
    }
    function terbilang($number) {
        $units = ['', 'ribu', 'juta', 'miliar', 'triliun'];
        $words = [
            '', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan', 
            'sepuluh', 'sebelas', 'dua belas', 'tiga belas', 'empat belas', 'lima belas', 
            'enam belas', 'tujuh belas', 'delapan belas', 'sembilan belas'
        ];
    
        $tens = ['', '', 'dua puluh', 'tiga puluh', 'empat puluh', 'lima puluh', 
            'enam puluh', 'tujuh puluh', 'delapan puluh', 'sembilan puluh'
        ];
    
        if ($number < 20) {
            return $words[$number];
        } elseif ($number < 100) {
            $unit = $number % 10;
            $ten = (int)($number / 10);
            return $tens[$ten] . ($unit ? ' ' . $words[$unit] : '');
        } elseif ($number < 1000) {
            $hundred = (int)($number / 100);
            $remainder = $number % 100;
            $wordHundred = $hundred > 1 ? $words[$hundred] . ' ratus' : 'seratus';
            return $wordHundred . ($remainder ? ' ' . $this->terbilang($remainder) : '');
        } else {
            $unitIndex = 0;
            $result = '';
    
            while ($number > 0) {
                $segment = $number % 1000;
                if ($segment > 0) {
                    // Menangani kasus khusus untuk seribu
                    if ($unitIndex == 1 && $segment == 1) {
                        $segmentText = 'seribu';
                    } else {
                        $segmentText = $this->terbilang($segment) . ' ' . $units[$unitIndex];
                    }
                    $result = $segmentText . ($result ? ' ' . $result : '');
                }
                $number = (int)($number / 1000);
                $unitIndex++;
            }
    
            return trim($result);
        }
    }
    public function download(Request $request)
    {
        $filePath = "{$request->path}/{$request->nama_file}";

        if (Storage::disk('local')->exists($filePath)) {
            return Storage::disk('local')->download($filePath);
        } else {
            return response()->json(['error' => 'File not found.'], Response::HTTP_NOT_FOUND);
        }
    }
}
