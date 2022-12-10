<?php

namespace App\Providers;

use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Umum;
use App\Models\RolesItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        view()->composer('*', function($view){
            if(Auth::check()){
                $userid = Auth::user()->id;
                $roles  = User::with('roles')
                            ->withCount('roles')
                            ->find($userid)
                            ->roles_count;
            }else{
                $roles = '';
            }

            $page_title = Umum::select('nama')->first()->nama;
            $logo       = Umum::select('logo')->first()->logo;

            $view->with([
                'roles_count' => $roles,
                'page_title'  => $page_title,
                'logo'        => $logo,
            ]);
        });

    }
}
