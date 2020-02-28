<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class sameUser
{

    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        if (!$user) return response()->json('Usuario no encontrado', 404);
        $_request = $request->all();
        if ($user->id != $_request["user_id"]) return response()->json('No autorizado', 401);

        return $next($request);
    }

}
