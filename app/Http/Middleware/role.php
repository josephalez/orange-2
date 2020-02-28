<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class role
{

    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        if (!$user) return response()->json('Usuario no encontrado', 404);
        
        $roles=array_slice(func_get_args(), 2);

        $hasRole=false;

        foreach($roles as $role){
            if ($user->role === $role) $hasRole= true; 
        }
        if(!$hasRole)return response()->json('No autorizado', 401);

        return $next($request);
    }

}
