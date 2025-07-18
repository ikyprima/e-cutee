<?php

namespace Modules\Cuti\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Cuti\Models\PersetujuanPimpinan;
use Validator;
use Redirect;
use Illuminate\Support\MessageBag;
class PersetujuanKepalaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('cuti::index');
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
        try{
            $rules = [
                'id_ajukan_cuti' => [
                    'required',
                ],
            ];
            $customMessages = [
                'required' => ':attribute harus di isi.',
                'unique'=> ':attribute sudah terdaftar',
                'email'=> 'format :attribute salah'
            ];
            $validator = Validator::make($request->all(), $rules, $customMessages)->validate();
          $persetujuanKepala =  PersetujuanPimpinan::firstOrCreate([
                'tanggal_persetujuan'=> date('Y-m-d'),
                'keterangan'=>$request->keterangan?$request->keterangan: null,
                'status' =>$request->status,
                'id_ajukan_cuti' => $request->id_ajukan_cuti
            ]);
            $requestGenerateDoc = new Request([
                "id" => $request->id_ajukan_cuti,
                "nomor" => $persetujuanKepala->id
            ]);
            app(CutiController::class)->generateDocumentIzinCuti($requestGenerateDoc);
            return to_route('admin')->with(['message'=>'Sukses Simpan Data']);
            // return Redirect::route('admin');

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
