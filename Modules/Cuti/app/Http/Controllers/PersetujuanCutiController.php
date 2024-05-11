<?php

namespace Modules\Cuti\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;
use Modules\Cuti\Models\AjukanCutiPersetujuan;
use Modules\Cuti\Models\DetailHirarki;
use Modules\Cuti\Models\AjukanCuti;
use Modules\Pegawai\Models\Pegawai;
use Auth;
class PersetujuanCutiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pegawai = Pegawai::where('nomor_induk_pegawai',Auth::user()->username)->first();
        $id_pegawai =  $pegawai->id;
        $dataCuti = AjukanCutiPersetujuan::where([['id_pegawai',$id_pegawai],['aktif',1]])
        ->with('masterajukancuti.pegawai.hasJabatan.jabatan')
        ->get()
        ->map(function($item){
            $tanggal = $item->masterajukancuti->detailTanggal->map(function($item){
                return [
                'title'=>$item->title,
                'date'=>$item->tgl,
                'color'=>$item->color
                ];
            });
            $detPersetujuan =  $item->masterajukancuti->detailPersetujuan->map(function($item){
                return [
                    'id_pegawai'=>$item->id,
                    'nama_pegawai'=>$item->pegawai?$item->pegawai->nama:null,
                    // 'jabatan'=>$item->pegawai?$item->pegawai->hasJabatan->jabatan->nama_jabatan:null,
                    'jabatan'=>$item->pegawai->jabatanOrganisasi->nama_jabatan,
                    'status'=>$item->status,
                    'aktif'=>$item->aktif,
                    'created_at'=>$item->created_at,
                    'updated_at'=>$item->updated_at,
                ];
            });
            return [
                'id'=>$item->id,
                'id_detail_hirarki'=>$item->id_detail_hirarki,
                'id_ajukan_cuti'=> $item->id_ajukan_cuti,
                'nip'=>$item->masterajukancuti->pegawai->nomor_induk_pegawai,
                'nama'=>$item->masterajukancuti->pegawai->nama,
                // 'jabatan'=>$item->masterajukancuti->pegawai->hasJabatan->jabatan->nama_jabatan,
                'jabatan'=>$item->pegawai->jabatanOrganisasi->nama_jabatan,
                'jenis_cuti'=>$item->masterajukancuti->jenisCuti,
                'alasan_cuti'=>$item->masterajukancuti->alasan_cuti,
                'alamat'=>$item->masterajukancuti->alamat,
                'telp'=> $item->masterajukancuti->telp,
                'status_pengajuan'=> $item->masterajukancuti->status, //status dokumen pengajuan cuti
                'status_persetujuan'=>$item->status, //status persetujuan per orang
                'tanggal_cuti'=>$tanggal,
                'detail_persetujuan'=> $detPersetujuan
                
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
        if($request->status === 0){
            //jika persetujuan ditolak
            AjukanCuti::where('id',$request->id_ajukan_cuti)->update(
                [
                    'status' => 2, //0 menunggu, 1 Disetujui, 2 Ditolak
                ],
            );
            AjukanCutiPersetujuan::where('id', $request->id)->update(
                [
                    'status' => 2, //0 menunggu, 1 Disetujui, 2 Ditolak
                ],
            );
            return to_route('admin-persetujuan-cuti')->with(['message'=>'Sukses Simpan Data']);
            
        }elseif($request->status === 1){
            //jika disetujui
           $detHirarki =  DetailHirarki::where('id',$request->id_detail_hirarki)->first();
           $selanjutnya = DetailHirarki::where('id_hirarki',$detHirarki->id_hirarki )
           ->where('urutan', '>', $detHirarki->urutan)
           ->orderBy('urutan', 'asc')
           ->first();
            if ($selanjutnya) {
                //update status aktif pada detail persetujuan
                AjukanCutiPersetujuan::where('id', $request->id)->update(
                    [
                        'status' => 1, //0 menunggu, 1 Disetujui, 2 Ditolak
                    ],
                );
                AjukanCutiPersetujuan::where('id_ajukan_cuti', $request->id_ajukan_cuti)
                ->where('id_detail_hirarki', $selanjutnya->id)
                ->update(
                    [
                        'aktif' => 1, //0 menunggu, 1 posisi persetujuan ada di sini
                    ],
                );
                
                return to_route('admin-persetujuan-cuti')->with(['message'=>'Sukses Simpan Data']);
            }else{
                //jika tidak ada berarti baris terakhir, atau prose persetujuan sudah selesai, update table master persetujuan
                AjukanCutiPersetujuan::where('id', $request->id)->update(
                    [
                        'status' => 1, //0 menunggu, 1 Disetujui, 2 Ditolak
                    ],
                );
                AjukanCuti::where('id',$request->id_ajukan_cuti)->update(
                    [
                        'status' => 1, //0 menunggu, 1 Disetujui, 2 Ditolak
                    ],
                );
                return to_route('admin-persetujuan-cuti')->with(['message'=>'Sukses Simpan Data']);
            }
        
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
}
