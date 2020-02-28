<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

use Illuminate\Support\Facades\DB;

class isOwner
{

    public function handle($request, Closure $next, $type, $adminAll=false)
    {

        $id = $request->route('id');
        $user = Auth::user();

        if($adminAll){
            if($user->role == "backoffice" || $user->role == "bodega"
                || $user->role == "backoffice_general" || $user->role == "mapa"
                || $user->role == "biker" || $user->role == "ejecutivo" || $user->role == "supervisor")
                    return $next($request);
        }

        if (false&&!$user) return response()->json('Usuario no encontrado', 404);

        $isOwner = true;

        $data= DB::table($type)->where("id","=", $id)->first();
        if (!$data) return response()->json('No encontrado', 404);

        if($type == "sales"){
            if($data->supervisor != $user->id && $data->analyst != $user->id && $data->seller != $user->id){
              $isOwner = false;
            }
        }

        if(!$isOwner)return response()->json('No estas autorizado', 403);

        return $next($request);
    }

}
