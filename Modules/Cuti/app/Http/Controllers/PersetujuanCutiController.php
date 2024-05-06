<?php

namespace Modules\Cuti\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;
use Modules\Cuti\Models\AjukanCutiPersetujuan;

class PersetujuanCutiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $id_pegawai = 1;

         $dataCuti = AjukanCutiPersetujuan::where([['id_pegawai',$id_pegawai],['aktif',1]])
        ->with('masterajukancuti.pegawai.hasJabatan.jabatan')
        ->get()->map(function($item){
            $tanggal = $item->masterajukancuti->detailTanggal->map(function($item){
               return [
                'title'=>$item->title,
                'date'=>$item->tgl,
                'color'=>$item->color
               ];

            });
            return [
                'nip'=>$item->masterajukancuti->pegawai->nomor_induk_pegawai,
                'nama'=>$item->masterajukancuti->pegawai->nama,
                'jabatan'=>$item->masterajukancuti->pegawai->hasJabatan->jabatan->nama_jabatan,
                'jenis_cuti'=>$item->masterajukancuti->jenisCuti,
                'alasan_cuti'=>$item->masterajukancuti->alasan_cuti,
                'alamat'=>$item->masterajukancuti->alamat,
                'telp'=> $item->masterajukancuti->telp,
                'status_pengajuan'=> $item->masterajukancuti->status,
                'status_persetujuan'=>$item->status,
                'tanggal_cuti'=>$tanggal,
                
            ];
        });
        //list pengajuan cuti
        return Inertia::render('Cuti/ListPersetujuan',[
            'dataCuti' => $dataCuti
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
    public function store(Request $request)
    {
        return $request->all();
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
