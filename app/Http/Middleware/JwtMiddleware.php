<?php

/*
    Capa Middleware relacionado con el inicio de sesión
    Author: David Nicolás Sánchez Sendoya, Augusto Enrique Salazar
*/

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware extends BaseMiddleware
{

    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return response()->json(['status' => 900, 'data' => 'Token invalido']);
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return response()->json(['status' => 901, 'data' => 'Token expirado']);
            }else{
                return response()->json(['status' => 902, 'data' => 'Falta Token en la peticion']);
            }
        }
        return $next($request);
    }
}

