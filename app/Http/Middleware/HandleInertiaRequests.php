<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

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
                    'id_header' => 0,
                    "header"=> "Manajemen",
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
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
            ],
            'menu' => $menuDashboard,
        ];
    }
}
