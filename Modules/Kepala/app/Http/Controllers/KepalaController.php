<?php

namespace Modules\Kepala\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;
use Modules\Kepala\Models\Kepala;

use Illuminate\Support\MessageBag;
use Redirect;
use Validator;

class KepalaController extends Controller
{
    //Modul Untuk Setting Kepala Badan
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kepala =  Kepala::with('pegawai')->paginate(10)->through(function($item){
            return[
                "id" => $item->id,
                "id_pegawai" =>$item->id_pegawai,
                "nip" =>$item->pegawai->nomor_induk_pegawai,
                "nama" => $item->pegawai->nama,
                "status"=> $item->status == 0 ? "Definitif" : "PLT"
            ];
        });

        return Inertia::render('Kepala/Index',[
            "data"=> $kepala
        ]);
        // return view('kepala::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kepala::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //jika definitif 
        //hapus semua dengan soft delete baru insert
        //jika PLT tambahkan Data Baru


        try {

            $rules = [
                'id_pegawai' => [
                    'required',
                ],
            ];
            $customMessages = [
                'required' => ':attribute harus di isi.',
                'unique'=> ':attribute sudah terdaftar',
                'email'=> 'format :attribute salah'
            ];
            Validator::make($request->all(), $rules, $customMessages)->validate();
           
            if ($request->status === false) {
                # soft delete semua data null
                
                Kepala::whereNull('deleted_at')->update(['deleted_at' => now()]);
                
            }
            $kepala = Kepala::firstOrCreate([
                'id_pegawai' => $request->id_pegawai,
                "status" => $request->status
            ]);
            return Redirect::route('kepala.index');
        } catch(\Illuminate\Database\QueryException $e){
            // return dd($e);
            $text= $e->getMessage();
            $errors = new MessageBag(['error_global' => [$e->errorInfo[2]]]);
            return Redirect::back()->withErrors($errors);
        }
    
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('kepala::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('kepala::edit');
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
    public function destroy($id) : RedirectResponse
    {
        try {
            Kepala::where('id',$id )
            ->delete();
            return Redirect::route('kepala.index');
        } catch(\Illuminate\Database\QueryException $e){
            // return dd($e);
            $text= $e->getMessage();
            $errors = new MessageBag(['error_global' => [$e->errorInfo[2]]]);
            return Redirect::back()->withErrors($errors);
        }
    }
}
