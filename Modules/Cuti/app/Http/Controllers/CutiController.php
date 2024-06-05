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
class CutiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if( Auth::user()->hasRole('admin')){
            $dataCuti = AjukanCuti::with('pegawai','jenisCuti','detailTanggal','detailPersetujuan.pegawai')->paginate(10)->through(function($item){

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
            ->with('pegawai.jabatanOrganisasi','detailTanggal','detailPersetujuan.pegawai')
            ->paginate(10)
            ->through(function($item){

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
}
