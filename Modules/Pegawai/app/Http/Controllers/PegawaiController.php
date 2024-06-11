<?php

namespace Modules\Pegawai\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Validator;
use Redirect;
use Illuminate\Support\MessageBag;
use Modules\Pegawai\Models\ModelPegawai;
use Modules\Cuti\Models\Hirarki;
use Modules\Cuti\Models\HirarkiHasPegawai;


use  App\Models\User;
class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) 
    {
        $is_api_request = $request->route()->getPrefix() === 'api/v1';
        
            if($request->has('searchall')){
                if($request->searchall != ''){
                    $pegawai = ModelPegawai::where('nomor_induk_pegawai', 'like', '%' . $request->searchall . '%')
                    ->orWhere('nama', 'like', '%' . $request->searchall . '%')
                    ->get();
                }else{
                    $pegawai = [];
                }
            
            }elseif($request->has('search')) {
                # code...
                $pegawai = ModelPegawai::where('nomor_induk_pegawai', 'like', '%' . $request->search . '%')
                ->orWhere('nama', 'like', '%' . $request->search . '%')
                ->paginate(10)->through(function($item){
            
                    return [
                        'id'=> $item->id,
                        'nomor_induk_pegawai'=> $item->nomor_induk_pegawai,
                        'nama'=> $item->nama,
                        'tgl_lahir'=>$item->tgl_lahir,
                        'nama_jabatan'=>$item->jabatanOrganisasi->nama_jabatan,
                        'stringstat' => [
                            'nama'=> $item->hasHirarki ? 'sudah setting' : 'belum setting',
                            'kode'=>  $item->hasHirarki ? 1 : 0,
                            'class'=> $item->hasHirarki ? 'text-green-600 bg-green-200' : 'text-red-600 bg-red-200',
                        ]
                    ];
                    
                });
                $pegawai->appends ( array (
                    'search' => $request->search
                ) );
                
            }else{

                $pegawai = ModelPegawai::with('hasHirarki')->paginate(10)->through(function($item){
                
                    return [
                        'id'=> $item->id,
                        'nomor_induk_pegawai'=> $item->nomor_induk_pegawai,
                        'nama'=> $item->nama,
                        'tgl_lahir'=>$item->tgl_lahir,
                        'nama_jabatan'=>$item->jabatanOrganisasi->nama_jabatan,
                        'stringstat' => [
                            'nama'=> $item->hasHirarki ? 'sudah setting' : 'belum setting',
                            'kode'=>  $item->hasHirarki ? 1 : 0,
                            'class'=> $item->hasHirarki ? 'text-green-600 bg-green-200' : 'text-red-600 bg-red-200',
                        ]
                    
                    ];
                    
                });

            
            }
            if ($is_api_request) {
                //jika request dari route api
                return $pegawai;
            }else{
                $masterHirarki = Hirarki::with('detailHirarki.pegawai')->get();
                return Inertia::render('Pegawai/Index',[
                    'pegawai'=>$pegawai,
                    'hirarki' => $masterHirarki

                ]);
            }
        
        
       
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pegawai::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //
    }
    public function addHirarki(Request $request): RedirectResponse
    {
       
        try{

            $rules = [
                'id_hirarki' => ['required'],
                'id_pegawai' => ['required']
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

            HirarkiHasPegawai::firstOrCreate([
                'id_hirarki' =>  $request->id_hirarki,
                'id_pegawai' => $request->id_pegawai,
            ]);

            return Redirect::route('pegawai.index');

        } catch(\Illuminate\Database\QueryException $e){
            // return dd($e);
            $text= $e->getMessage();
            $errors = new MessageBag(['nama' => [$e->errorInfo[2]]]);
            return Redirect::back()->withErrors($errors);
        }
    }
    /**
     * Show the specified resource.
     */
    public function show(Request $request, $id = null)
    {

        
        return view('pegawai::show');
        
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('pegawai::edit');
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
}
