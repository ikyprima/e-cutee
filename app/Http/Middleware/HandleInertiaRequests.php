<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Auth;
class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        if (Auth::check()) {
            if( Auth::user()->hasRole('admin')){
                $menuDashboard = collect([
                    [
                    'id_header' => 0,
                    "header"=> "Home",
                    "order"=> 0,
                    "menu" => array(
                        [
                            "id"=> 1,
                            "title"=> "Dashboard",
                            "url"=> "dashboard",
                            "name_route"=> "admin",
                            "icon"=> null,
                            'children'=>[]
        
                        ],
                    )
                        ],
                        [
                            'id_header' => 1,
                            "header"=> "Manajemen",
                            "order"=> 0,
                            "menu" => array(
                                [
                                    "id"=> 1,
                                    "title"=> "Pegawai",
                                    "url"=> "pegawai",
                                    "name_route"=> "pegawai.index",
                                    "icon"=> null,
                                    'children'=>[]
                
                                ],
                                [
                                    "id"=> 2,
                                    "title"=> "jabatan",
                                    "url"=> "jabatan",
                                    "name_route"=> "jabatan.index",
                                    "icon"=> null,
                                    'children'=>[]
                
                                ],
                                [
                                    "id"=> 3,
                                    "title"=> "Alur Disposisi Cuti",
                                    "url"=> "hirarkicuti",
                                    "name_route"=> "hirarkicuti.index",
                                    "icon"=> null,
                                    'children'=>[]
                
                                ],
                                [
                                    "id"=> 4,
                                    "title"=> "Rekap Cuti",
                                    "url"=> "rekap-cuti",
                                    "name_route"=> "admin-rekap-cuti",
                                    "icon"=> null,
                                    'children'=>[]
                
                                ],
                                [
                                    "id"=> 5,
                                    "title"=> "List Pengajuan Cuti",
                                    "url"=> "list-pengajuan-cuti",
                                    "name_route"=> "admin-list-pengajuan-cuti",
                                    "icon"=> null,
                                    'children'=>[]
                
                                ]
                            )
                        ],
                        [
                            'id_header' => 2,
                            "header"=> "Setting",
                            "order"=> 0,
                            "menu" => array(
                                [
                                    "id"=> 1,
                                    "title"=> "User",
                                    "url"=> "user",
                                    "name_route"=> "user.index",
                                    "icon"=> null,
                                    'children'=>[]
                
                                ],
                                [
                                    "id"=> 2,
                                    "title"=> "role",
                                    "url"=> "role",
                                    "name_route"=> "role.index",
                                    "icon"=> null,
                                    'children'=>[]
                
                                ],
                                [
                                    "id"=> 2,
                                    "title"=> "permission",
                                    "url"=> "permission",
                                    "name_route"=> "permission.index",
                                    "icon"=> null,
                                    'children'=>[]
                
                                ]
                            )
                            ]
                    ]
        
                );
            }else{
                $menuDashboard = collect([
                    [
                    'id_header' => 0,
                    "header"=> "Home",
                    "order"=> 0,
                    "menu" => array(
                        [
                            "id"=> 1,
                            "title"=> "Dashboard",
                            "url"=> "dashboard",
                            "name_route"=> "admin",
                            "icon"=> null,
                            'children'=>[]
        
                        ],
                    )
                        ],
                        [
                            'id_header' => 1,
                            "header"=> "Manajemen",
                            "order"=> 0,
                            "menu" => array(
                                [
                                    "id"=> 1,
                                    "title"=> "Ajukan Cuti",
                                    "url"=> "admin/cuti",
                                    "name_route"=> "admin-index-cuti",
                                    "icon"=> null,
                                    'children'=>[]
                
                                ],
                                [
                                    "id"=> 2,
                                    "title"=> "List Persetujuan",
                                    "url"=> "admin/cuti/persetujuan",
                                    "name_route"=> "admin-persetujuan-cuti",
                                    "icon"=> null,
                                    'children'=>[]
                
                                ],
                            
                            )
                        ],
                        [
                            'id_header' => 2,
                            "header"=> "Setting",
                            "order"=> 0,
                            "menu" => array(
                                [
                                    "id"=> 1,
                                    "title"=> "Profile",
                                    "url"=> "user",
                                    "name_route"=> "user.index",
                                    "icon"=> null,
                                    'children'=>[]
                
                                ],
                               
                            )
                            ]
                    ]
        
                );
            }
        }else{
            $menuDashboard = [];
        }
      
        
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
            ],
            'menu' => $menuDashboard,
        ];
    }
}
