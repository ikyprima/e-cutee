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
                $pegawai = ModelPegawai::where('nomor_induk_pegawai', 'like', '%' . $request->searchall . '%')
                ->orWhere('nama', 'like', '%' . $request->searchall . '%')
                ->get();
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
                        'nama_jabatan'=>$item->jabatanOrganisasi->nama_jabatan
                    ];
                    
                });
                $pegawai->appends ( array (
                    'search' => $request->search
                ) );
                
            }else{
                $pegawai = ModelPegawai::paginate(10)->through(function($item){
            
                    return [
                        'id'=> $item->id,
                        'nomor_induk_pegawai'=> $item->nomor_induk_pegawai,
                        'nama'=> $item->nama,
                        'tgl_lahir'=>$item->tgl_lahir,
                        'nama_jabatan'=>$item->jabatanOrganisasi->nama_jabatan
                    ];
                    
                });
            
            }
            if ($is_api_request) {
                //jika request dari route api
                return $pegawai;
            }else{
                return Inertia::render('Pegawai/Index',[
                    'pegawai'=>$pegawai
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
