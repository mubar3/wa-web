<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\RolesItem;
use Illuminate\Support\Facades\DB;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $roleitem, $role)
    {
        $roles_id = session('roles_id');
        $item_id = RolesItem::where('nama', $roleitem)->first()->id;

        $permission = DB::table('roles_item_pivot')
                        ->where('roles_id', $roles_id)
                        ->where('roles_item_id', $item_id)
                        ->first();

        if($permission != null){
            if($permission->$role == '1'){
                return $next($request);
            }else{
                return redirect('/403');
            }
        }else{
            return redirect('/403');
        }
    }
}
