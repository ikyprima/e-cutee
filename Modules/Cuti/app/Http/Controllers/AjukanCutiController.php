<?php

namespace Modules\Cuti\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
// use Illuminate\Http\Response;
use Inertia\Inertia;
use Inertia\Response;
use Redirect;
use Modules\Pegawai\Models\PegawaiHasUser;
use Modules\Pegawai\Models\Pegawai;
use Modules\Cuti\Models\AjukanCuti;
use Modules\Cuti\Models\AjukanCutiPersetujuan;
use Modules\Cuti\Models\AjukanCutiTanggal;
use Modules\Cuti\Models\AjukanCutiLampiran;
use Modules\Cuti\Models\Notifikasi;
use Auth;
use Validator;
use Storage;
use DB;
class AjukanCutiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    

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
    public function store(Request $request)
    {
        $pegawai = Pegawai::with(['jabatanOrganisasi','hasHirarki.hirarki.detailHirarki'])->where('nomor_induk_pegawai',Auth::user()->username)->first();
        $requestnew = new Request([
            "id" => $pegawai->id,
        ]);
        $rekapCuti = app(CutiController::class)->sisaCuti($requestnew);
      
        $jumtanggal = count($request->tanggal);
        if ($request->jenisCuti == 1 && ($jumtanggal > $rekapCuti['sisa_cuti_tahunan'])) {
            $errors = new MessageBag(['global_error' => 'Sisa Kuota Cuti Tahunan Anda Tidak Mencukupi']);
            return Redirect::back()->withErrors($errors);
        }
       

        // $idUser = 1;
        // $dataInfo = PegawaiHasUser::with('pegawai')->where('id_user',$idUser)->first();
        // $pegawai = collect($dataInfo->pegawai);
        // $jabatan = collect($dataInfo->pegawai->hasJabatan->jabatan);
        // $hirarki = collect($dataInfo->pegawai->hasHirarki->hirarki);

        // $detailHirarki = collect($dataInfo->pegawai->hasHirarki->hirarki->detailHirarki)->map(function($item){

        //     return [
        //         "id"=> $item['id'],
        //         "id_hirarki"=> $item['id_hirarki'],
        //         "urutan"=> $item['urutan'],
        //         "id_jabatan"=> $item['id_jabatan'] ,
        //         "deleted_at"=> $item['deleted_at'] ,
        //         "created_at"=> $item['created_at'] ,
        //         "updated_at"=> $item['updated_at'],
        //         "id_pegawai"=>$item->pegawaiByJabatan?$item->pegawaiByJabatan->id_pegawai:null
        //     ];
        // });


        // $pegawai['jabatan']= $jabatan;
        // $pegawai['hirarki']= $hirarki;
        // $pegawai['hirarki']['detail']= $detailHirarki;
        
        $rules = [
            'jenisCuti' => ['required'],
            'alasanCuti' => ['required'],
            'noTelp' => ['required', 'numeric', 'max_digits:13'],
          
        ];
        if ($request->file != '') {
            $rules ['file'] = 'mimes:jpg,jpeg,pdf|max:2048';
        }
     
        $customMessages = [
            'file.file' => ':attribute harus berupa file yang valid.',
            'file.mimes' => ':attribute haruss bertipe: jpeg atau pdf.',
            'file.max' => 'Ukuran :attribute tidak boleh lebih dari 2MB.',
            'required' => 'Field :attribute harus di isi.',
            'unique'=> 'field sudah terdaftar',
            'email'=> 'format field salah',
            'numeric'=> 'isi hanya boleh angka',
            'max'=> 'maximal :max karakter',
            'max_digits'=>'tidak boleh lebih dari :max angka'
        ];

        
        Validator::make($request->all(), $rules, $customMessages)
        ->validate();

        $jabatan =  collect($pegawai->jabatanOrganisasi);
        $hirarki = collect($pegawai->hasHirarki->hirarki);

        $detailHirarki = collect($pegawai->hasHirarki->hirarki->detailHirarki)->map(function($item){

            return [
                "id"=> $item['id'],
                "id_hirarki"=> $item['id_hirarki'],
                "urutan"=> $item['urutan'],
                "id_jabatan"=> $item['id_jabatan'] ,
                "deleted_at"=> $item['deleted_at'] ,
                "created_at"=> $item['created_at'] ,
                "updated_at"=> $item['updated_at'],
                "id_pegawai"=> $item['id_pegawai'],
                "id_pegawai_dari_jabatan"=>$item->pegawaiByJabatan?$item->pegawaiByJabatan->id_pegawai:null
            ];
        });

        $pegawai['jabatan']= $jabatan;
        $pegawai['hirarki']= $hirarki;
        $pegawai['hirarki']['detail']= $detailHirarki;
    
        // return $pegawai;
        
        try {
            //insert ke table ajukan cuti
          
            DB::beginTransaction();
            $formAjukanCuti = AjukanCuti::create([
                'id_jenis_cuti'=> $request->jenisCuti,
                'alasan_cuti'=> $request->alasanCuti,
                'alamat'=> $request->alamat,
                'telp'=> $request->noTelp,
                'id_pegawai'=> $pegawai['id']

            ]);

            $id_ajukan_cuti = $formAjukanCuti->id;
            
            foreach ($request->tanggal as $key => $item) {
                AjukanCutiTanggal::create([
                    'id_ajukan_cuti' =>  $id_ajukan_cuti,
                    'title' =>  $item['title'],
                    'tgl' => $item['tgl'],
                    'color'=> $item['color']
                ]);
            }
            foreach ($detailHirarki as $key => $item) {
            
                AjukanCutiPersetujuan::create([
                    'id_ajukan_cuti' =>  $id_ajukan_cuti,
                    'id_detail_hirarki' =>  $item['id'],
                    'id_pegawai' =>  $item['id_pegawai'],
                    'aktif' => $item['urutan']==1?1:0
                ]);
            }

            //insert ke notifikasi dengan id pegawai  dari detail hirariki yang pertama
            Notifikasi::create(
                [

                    'id_pegawai' => $detailHirarki[0]['id_pegawai'],
                    'id_ajukan_cuti'=> $id_ajukan_cuti,
                    'judul'=> 'Pengajuan Cuti',
                    'deskripsi'=> "Ada Penajuan Cuti Yang Harus Di ACC Dari {$pegawai["nama"]}"
                ]
            );


            if($request->file != ''){

                // try {
                //     Storage::disk('webdav')->put('file.txt', 'Konten file');
                // } catch (\Exception $e) {
                //     dd($e->getMessage());
                // }

             

                if (!Storage::disk('local')->exists('lampiran_cuti')) {
                    Storage::disk('local')->makeDirectory('lampiran_cuti');
                }
                
                $file      = $request->file('file');
                $fileName   =  $id_ajukan_cuti.'_'.time() . '.' . $file->extension();
                Storage::disk('local')->putFileAs('lampiran_cuti', $file, $fileName);

                AjukanCutiLampiran::create([
                    'id_cuti_ajukan' =>  $id_ajukan_cuti,
                    'path' => 'lampiran_cuti',
                    'nama_file' =>  $fileName
                ]);

            }

            DB::commit();
            return Redirect::route('admin-index-cuti');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return $th;
        }
    
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

    public function ajukanCuti(Request $request){

       
        $pegawai = Pegawai::where('nomor_induk_pegawai',Auth::user()->username)->first();
        $dataCuti = AjukanCuti::with('detailTanggal')->where('id_pegawai',$pegawai->id)
        ->where('status','!=',2)->get();
        $tanggal =  $dataCuti->pluck('detailTanggal')->flatten();
        $request = new Request([
            "id" => $pegawai->id,
        ]);
        $rekapCuti = app(CutiController::class)->sisaCuti($request);
        return Inertia::render('Cuti/AjukanCuti',[
            'data_tanggal' => $tanggal,
            'rekap_cuti' =>$rekapCuti
        ]);
    }

    public function viewLampiran(Request $request)
        {
            
            //  if(storage::disk('local')->exists('lampiran_cuti/8_1720168s494.pdf')){
            //     return 'true';
            //  }else{
            //     return 'false';
            //  };
            $pathFile = $request->path_file;
            $namaFile = $request->nama_file;
            $filePath = storage_path('app/'.$pathFile.'/'.$namaFile);
            // Pastikan file ada
            if (!file_exists($filePath)) {
                
                // abort(404);
                return response()->json(['error' => 'File not fousnd.'], 404);
            }else{

                $extension = pathinfo($filePath, PATHINFO_EXTENSION);
                switch ($extension) {
                    case 'pdf':
                        $contentType = 'application/pdf';
                        break;
                    case 'jpg':
                    case 'jpeg':
                        $contentType = 'image/jpeg';
                        break;
                    default:
                        return response()->json(['error' => 'Unsupported file type.'], 400);
                }
                
            return response()->file($filePath, [

                'Content-Type' =>$contentType,
                'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
                'Pragma' => 'no-cache',
                'Expires' => '0',
            ]);
            }

        }
}
