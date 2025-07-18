<?php

namespace Modules\Jabatan\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\MessageBag;
use Redirect;
use Validator;
use Inertia\Inertia;
use Modules\Jabatan\Models\JabatanOrganisasi;


class JabatanOrganisasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $is_api_request = $request->route()->getPrefix() === 'api/v1';

        if($request->has('searchall')){
            if($request->searchall != ''){
                $jabatanOrg = JabatanOrganisasi::where('nama_jabatan', 'like', '%' . $request->searchall . '%')
                ->get();
            }else{
                $jabatanOrg = [];
            }
        
        }elseif($request->has('search')) {
            # code...
            $jabatanOrg = JabatanOrganisasi::where('nama_jabatan', 'like', '%' . $request->search . '%')
            ->paginate(10)->through(function($item){
        
                return [
                    'id'=> $item->id,
                    'nama_jabatan'=> $item->nama_jabatan
                ];
                
            });
            $jabatanOrg->appends ( array (
                'search' => $request->search
            ) );
            
        }else{

            $jabatanOrg = JabatanOrganisasi::paginate(10)->through(function($item){
            
                return [
                    'id'=> $item->id,
                    'nama_jabatan'=> $item->nama_jabatan,
                    
                ];
                
            });

        
        }
        if ($is_api_request) {
            //jika request dari route api
            return $jabatanOrg;
        }else{
            return Inertia::render('Pegawai/Index',[
                'data'=>$jabatanOrg,

            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jabatan::create');
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
        return view('jabatan::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('jabatan::edit');
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
