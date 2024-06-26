<?php

namespace Modules\Cuti\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
// use Illuminate\Http\Response;
use Inertia\Inertia;
use Inertia\Response;
use Redirect;
use Modules\Pegawai\Models\PegawaiHasUser;
use Modules\Pegawai\Models\Pegawai;
use Modules\Cuti\Models\AjukanCuti;
use Modules\Cuti\Models\AjukanCutiPersetujuan;
use Modules\Cuti\Models\AjukanCutiTanggal;
use Auth;
use Validator;
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
            'noTelp' => ['required', 'numeric', 'max_digits:13']
        ];
        $customMessages = [
            'required' => 'field harus di isi.',
            'unique'=> 'field sudah terdaftar',
            'email'=> 'format field salah',
            'numeric'=> 'isi hanya boleh angka',
            'max'=> 'maximal :max karakter',
            'max_digits'=>'tidak boleh lebih dari :max angka'
        ];

        
        Validator::make($request->all(), $rules, $customMessages)
        ->validate();


        $pegawai = Pegawai::with(['jabatanOrganisasi','hasHirarki.hirarki.detailHirarki'])->where('nomor_induk_pegawai',Auth::user()->username)->first();
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
    
        try {
            //insert ke table ajukan cuti
          
            
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
            return Redirect::route('admin-index-cuti');
        } catch (\Throwable $th) {
            //throw $th;
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
        
        return Inertia::render('Cuti/AjukanCuti');
    }
}
