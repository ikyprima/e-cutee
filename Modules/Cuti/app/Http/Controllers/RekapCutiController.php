<?php

namespace Modules\Cuti\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Validator;
use Redirect;
use Illuminate\Support\MessageBag;
use Modules\Pegawai\Models\Pegawai;
use Modules\Cuti\Models\JenisCuti;
use Illuminate\Support\Facades\DB;
class RekapCutiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $master = JenisCuti::all();
        $rekapcuti = Pegawai::with('dataAjukanCuti.detailTanggal')->paginate(10)->through(function($item)use($master){
            $data = collect( [
                'nip'=>$item->nomor_induk_pegawai,
                'nama'=>$item->nama,
            ]);

            foreach ($master as $key => $value) {
                $jumlah =  $item->dataAjukanCuti->where('id_jenis_cuti',$value['id'])->sum(function ($item) {
                    return count($item->detailTanggal);
                }); 
                $data->put(strtolower(str_replace(' ', '_', $value['jenis_cuti'])), (string)$jumlah);
            }
            return $data;
        });
        
        
      


        return Inertia::render('Cuti/RekapCuti',[
            'rekapcuti' => $rekapcuti
        ]);
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
}
