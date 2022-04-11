<?php

/*
    Capa controlador relacionado con el inicio de sessión
    Author: David Nicolás Sánchez Sendoya, Augusto Enrique Salazar
*/

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\AO\Authenticate\AuthenticateAO;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Log;

class AuthenticateController extends Controller
{
    /* Método usado para realizar la autenticación de un usuario */
    public function authenticate(Request $request){
        $user = AuthenticateAO::getUserByUsername($request->username);
        if(sizeof($user) == 1){
            $credentials = ['email' => $user[0]->email, 'password' => $request->password];
            try {
                if (!$token = JWTAuth::attempt($credentials)) {
                    return response()->json(['error' => 'Credenciales Invalidas'], 400);
                }
            } catch (JWTException $e) {
                return response()->json(['error' => 'No fue posible crearse  el token'], 500);
            }
        }else{
            return response()->json(['error' => 'Usuario no existe'], 404);
        }
        return response()->json(compact('token'));
    }

    public function getAuthenticatedUser()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            if (!$user) {
                return response()->json(['Usuario no encontrado'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
                return response()->json(['Token Expirado'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
                return response()->json(['Token Inválido'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
                return response()->json(['Falta Token en la peticion'], $e->getStatusCode());
        }
        return response()->json($user);
    }

    /* Método usado para realizar la destrucción de token y cerrar sesión */
    public function logout(){
        $response['status'] = 400;
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            $response['status'] = 200;
        } catch (\Throwable $th) {
            Log::error('No fue posible cerrar sesión y destruir token M:'.$th->getMessage().' | L:'.$th->getLine().' F:'.$th->getFile());
        }
        return $response;
        
    }
}

