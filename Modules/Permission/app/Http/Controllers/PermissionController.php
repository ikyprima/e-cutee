<?php

namespace Modules\Permission\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Permission\Models\Permission;
use Inertia\Inertia;
use Validator;
use Redirect;
use Illuminate\Support\MessageBag;
class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permission = Permission::paginate(10)->through(function($item){
            return collect([
            
                'guard_name'=>$item->guard_name,
                'id'=>$item->id,
                'name'=>$item->name,
                'controller'=>$item->rute?$item->rute->controller:'-',
                'function'=>$item->rute?$item->rute->function:'-'
            
            ]);
        });
        return Inertia::render('Permission/Permissions',[
            'permission'=>$permission
        ]);
    
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('permission::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        try{
            $rules = [
                'permission' => [
                    'required',
                ],
            ];
            
            $customMessages = [
                'required' => ':attribute harus di isi.',
                'unique'=> ':attribute sudah terdaftar',
                'email'=> 'format :attribute salah'
            ];
            $validator = Validator::make($request->all(), $rules, $customMessages)->validate();
            $permission = Permission::firstOrCreate([
                'name' => $request->permission
            ]);
            return back(303);

        } catch(\Illuminate\Database\QueryException $e){
            // return dd($e);
            $text= $e->getMessage();
            $errors = new MessageBag(['permission' => [$e->errorInfo[2]]]);
            return Redirect::back()->withErrors($errors);
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('permission::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('permission::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $rules = [
                'permission' => [
                    'required',
                ],
            ];
            
            
            $customMessages = [
                'required' => ':attribute harus di isi.',
                'unique'=> ':attribute sudah terdaftar',
                'email'=> 'format :attribute salah'
            ];
            $validator = Validator::make($request->all(), $rules, $customMessages)->validate();
            $permission = Permission::where('id',$id)->update(
            
                [
                
                    'name' => $request->permission,
                
                ],
            );
    
            return back(303);
        } catch(\Illuminate\Database\QueryException $e){
            // return dd($e);
            $text= $e->getMessage();
            $errors = new MessageBag(['permission' => [$e->errorInfo[2]]]);
            return Redirect::back()->withErrors($errors);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {

            Permission::where('id',$id )
            ->delete();
            return back(303);
        } catch(\Illuminate\Database\QueryException $e){
            // return dd($e);
            $text= $e->getMessage();
            $errors = new MessageBag(['nama' => [$e->errorInfo[2]]]);
            return Redirect::back()->withErrors($errors);
        }
    }
}
