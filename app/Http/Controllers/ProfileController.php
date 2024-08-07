<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use Modules\Pegawai\Models\Pegawai;
use Modules\Cuti\Models\AjukanCuti;
use Modules\Cuti\Http\Controllers\CutiController;

use Carbon\Carbon;
class ProfileController extends Controller
{
    public function admin(Request $request){
        
        $tahun = Carbon::now()->year;
        if( Auth::user()->hasRole('admin')){
            return Inertia::render('Admin/index-admin');
        
        }elseif (Auth::user()->hasRole('pimpinan')) {
            $dataCuti = AjukanCuti::where('status',1)
            ->doesntHave('persetujuanPimpinan')
            ->with('persetujuanPimpinan','dokumenOutput','pegawai.jabatanOrganisasi','jenisCuti','detailTanggal','detailPersetujuan.pegawai')
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->through(function($item){

                if($item->status == 0){
                    $stat = 'Menunggu Persetujuan';
                    $class = 'text-blue-600 bg-blue-200';
                }elseif($item->status == 1){
                    $stat = 'Disetujui Atasan Langsung';
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
        
            return Inertia::render('Admin/index-pimpinan',[
                'dataCuti' => $dataCuti,
                'header' => "Persetujuan Kepala Badan",
                'message' => session('message')
            ]);
        
        }else{

            $pegawai = Pegawai::where('nomor_induk_pegawai',Auth::user()->username)->with('dataAjukanCuti.detailTanggal')->first();
            $request = new Request([
                "id" => $pegawai->id,
            ]);
            $rekapCuti = app(CutiController::class)->sisaCuti($request);
            $dataCuti = AjukanCuti::with('jenisCuti')
            ->where('id_pegawai',$pegawai->id)
            ->whereYear('created_at',$tahun)
            ->orderBy('created_at', 'desc')
            ->with('pegawai.jabatanOrganisasi','detailTanggal','detailPersetujuan.pegawai')
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
            

            return Inertia::render('Admin/index',[
                'data_rekap'=> $rekapCuti['data_rekap'],
                'sisa_cuti_tahunan' => $rekapCuti['sisa_cuti_tahunan'],
                'dataCuti' =>$dataCuti
            ]);
        }   

    }
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

   
}
