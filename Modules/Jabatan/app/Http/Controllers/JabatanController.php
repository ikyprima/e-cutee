<?php

namespace Modules\Jabatan\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Illuminate\Support\MessageBag;
use Redirect;
use Validator;
use Inertia\Inertia;
use Modules\Jabatan\Models\Jabatan;
class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $is_api_request = $request->route()->getPrefix() === 'api/v1';

        if($request->has('searchall')){
            if($request->searchall != ''){
                $jabatanDef = Jabatan::where('nama_jabatan', 'like', '%' . $request->searchall . '%')
                ->get();
            }else{
                $jabatanDef = [];
            }
        
        }elseif($request->has('search')) {
            # code...
            $jabatanDef = Jabatan::where('nama_jabatan', 'like', '%' . $request->search . '%')
            ->paginate(10)->through(function($item){
        
                return [
                    'id'=> $item->id,
                    'nama_jabatan'=> $item->nama_jabatan
                ];
                
            });
            $jabatanDef->appends ( array (
                'search' => $request->search
            ) );
            
        }else{

            $jabatanDef = Jabatan::paginate(10)->through(function($item){
            
                return [
                    'id'=> $item->id,
                    'nama_jabatan'=> $item->nama_jabatan,
                    
                ];
                
            });

        
        }
        if ($is_api_request) {
            //jika request dari route api
            return $jabatanDef;
        }else{
            return Inertia::render('Pegawai/Index',[
                'data'=>$jabatanDef,
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
        try{
            $rules = [
                'nama_jabatan' => [
                    'required',
                ],
            ];
            $customMessages = [
                'required' => ':attribute harus di isi.',
                'unique'=> ':attribute sudah terdaftar',
                'email'=> 'format :attribute salah'
            ];
            $validator = Validator::make($request->all(), $rules, $customMessages)->validate();
            $role = Jabatan::firstOrCreate([
                'nama_jabatan' => $request->nama_jabatan
            ]);
           

            return Redirect::route('jabatan.index');

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
        try {
            $rules = [
                'nama_jabatan' => [
                    'required',
                ],
            ];
            
            
            $customMessages = [
                'required' => ':attribute harus di isi.',
                'unique'=> ':attribute sudah terdaftar',
                'email'=> 'format :attribute salah'
            ];
            $validator = Validator::make($request->all(), $rules, $customMessages)->validate();
        
            $jabatan = Jabatan::updateOrCreate(
                [
                    'id'   => $id,
                ],
                [
                
                    'nama_jabatan' => $request->nama_jabatan,
                
                ],
            );
    
            return Redirect::route('jabatan.index');
        } catch(\Illuminate\Database\QueryException $e){
            // return dd($e);
            $text= $e->getMessage();
            $errors = new MessageBag(['error_global' => [$e->errorInfo[2]]]); //ganti 'role' dengan global error pada file vue
            return Redirect::back()->withErrors($errors);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) : RedirectResponse
    {
        try {
            Jabatan::where('id',$id )
            ->delete();
            return Redirect::route('jabatan.index');
        } catch(\Illuminate\Database\QueryException $e){
            // return dd($e);
            $text= $e->getMessage();
            $errors = new MessageBag(['error_global' => [$e->errorInfo[2]]]);
            return Redirect::back()->withErrors($errors);
        }
    }
}
