<?php

namespace Modules\Role\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Validator;
use Redirect;
use Illuminate\Support\MessageBag;
use Modules\Permission\Models\Permission;
use Modules\Role\Models\Role;
class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : Response
    {
        $role=Role::with('permissions')->paginate(10);
        $role = $role->through(function ($item){
            $permission = collect($item->permissions)->map(function ($details,$key){
                return collect([
                    "id" => $details->id,
                    "name" => $details->name,
                    "guard_name" => $details->guard_name
                ]);
            });
            return collect([
                'id' => $item->id,
                'name' => $item->name,
                'guard_name'=>$item->guard_name,
                'permission' =>$permission,
                'created_at'=>$item->created_at
            ]);
        });
        $permission = Permission::all();
        // return Inertia::render('Admin/tes');
        return Inertia::render('Role/Role',[
            'role'=>$role,
            'permission'=> $permission
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('role::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) : RedirectResponse
    {
        try{
            $rules = [
                'role' => [
                    'required',
                ],
            ];
            $customMessages = [
                'required' => ':attribute harus di isi.',
                'unique'=> ':attribute sudah terdaftar',
                'email'=> 'format :attribute salah'
            ];
            $validator = Validator::make($request->all(), $rules, $customMessages)->validate();
            $role = Role::firstOrCreate([
                'name' => $request->role
            ]);
            $role->givePermissionTo($request->permission);

            return Redirect::route('role.index');

        } catch(\Illuminate\Database\QueryException $e){
            // return dd($e);
            $text= $e->getMessage();
            $errors = new MessageBag(['role' => [$e->errorInfo[2]]]);
            return Redirect::back()->withErrors($errors);
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('role::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('role::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) : RedirectResponse
    {
        try {
            $rules = [
                'role' => [
                    'required',
                ],
            ];
            
            
            $customMessages = [
                'required' => ':attribute harus di isi.',
                'unique'=> ':attribute sudah terdaftar',
                'email'=> 'format :attribute salah'
            ];
            $validator = Validator::make($request->all(), $rules, $customMessages)->validate();
        
            $role = Role::updateOrCreate(
                [
                    'id'   => $id,
                ],
                [
                
                    'name' => $request->role,
                
                ],
            );
       
            $role->syncPermissions($request->permission);
            return Redirect::route('role.index');
        } catch(\Illuminate\Database\QueryException $e){
            // return dd($e);
            $text= $e->getMessage();
            $errors = new MessageBag(['role' => [$e->errorInfo[2]]]); //ganti 'role' dengan global error pada file vue
            return Redirect::back()->withErrors($errors);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) : RedirectResponse
    {
        try {
            Role::where('id',$id )
            ->delete();
            return Redirect::route('role.index');
        } catch(\Illuminate\Database\QueryException $e){
            // return dd($e);
            $text= $e->getMessage();
            $errors = new MessageBag(['role' => [$e->errorInfo[2]]]);
            return Redirect::back()->withErrors($errors);
        }
    }
}
