<?php

/*
    Capa Middleware relacionado con la verificación de permisos de un usuario en sesión
    Author: David Nicolás Sánchez Sendoya, Augusto Enrique Salazar
*/

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Illuminate\Http\Request;
use App\AO\Roles\RolesAO;

class verifyPermissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(RolesAO::getPermissions(JWTAuth::user()->rol)[0]->key == 'ADMIN'){
            return $next($request);
        }else{
            return response()->json(['status' => 903, 'data' => 'No tiene permisos suficientes para realizar la acción solicitada.']);
        }
    }
}
