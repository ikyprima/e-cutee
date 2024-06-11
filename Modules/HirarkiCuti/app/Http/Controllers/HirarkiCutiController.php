<?php

namespace Modules\HirarkiCuti\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Cuti\Models\Hirarki;
use Modules\Cuti\Models\DetailHirarki;
use Inertia\Inertia;
use Inertia\Response;
use Validator;
use Redirect;
use Illuminate\Support\MessageBag;
class HirarkiCutiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hirarki=Hirarki::with('detailHirarki.pegawai.jabatanOrganisasi')->paginate(10)
        ->through(function($item){
        $detail = $item->detailhirarki->map(function($itemdet){
            return [
                "id"=>$itemdet->id,
                "badge"=> "URUTAN ".$itemdet->urutan,
                'id_pegawai'=> $itemdet->id_pegawai,
                'header'=>$itemdet->pegawai->nama,
                "subheader"=> $itemdet->pegawai->jabatanOrganisasi->nama_jabatan
            ];
        });
        return [
            'id'=>$item->id,
            'nama_hirarki'=>$item->nama_hirarki,
            'detail'=> $detail
        ];
    });
        return Inertia::render('Hirarki/Index',[
            'hirarki'=>$hirarki
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('hirarkicuti::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        try{

            $rules = [
                'nama_hirarki' => ['required'],
                'detail.*.id_pegawai' => [
                    'required',
                ],
                'detail.*.urutan' => [
                    'required',
                ],
                
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

            $hirarki = Hirarki::firstOrCreate([
                'nama_hirarki' => $request->nama_hirarki,
            ]);

            $idHirarki = $hirarki->id;

          
            
            foreach ($request->detail as $key => $item) {
               
                DetailHirarki::firstOrCreate([
                    'id_hirarki' =>  $idHirarki,
                    'id_pegawai' => $item['id_pegawai'],
                ], [
                    'urutan' => $item['urutan'],
                ]);
            }

            return Redirect::route('hirarkicuti.index');

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
    public function show($id)
    {
        return view('hirarkicuti::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('hirarkicuti::edit');
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
