<?php

/*
    Capa de lógica de negocios: capa en la que se procesa la lógica de negocio del módulo de roles
    Author: David Nicolás Sánchez Sendoya, Augusto Enrique Salazar
*/
namespace App\BL\Roles;
use App\AO\Roles\RolesAO;
use Illuminate\Support\Facades\Hash;
use Log;
use JWTAuth;

class RolesBL
{
    /* Método usado para obtener todos los roles de usuario para los usuarios */
    public static function getAllRoles(){
        $response['status'] = 400;
        try {
            $response['data'] = RolesAO::getAllRoles();
            $response['status'] = 200;
        } catch (\Throwable $th) {
            $response['msg'] = "No fue posible obtenerse los roles.";
            Log::error('Error al obtener roles: '.$th->getMessage().' | L: '.$th->getLine().' | F:'.$th->getFile());
        }
        return $response;
    }

    /* Método usado para obtener el rol del usuario en sesión */
    public static function getPermissions(){
        $response['status'] = 400;
        try {
            $response['data'] = RolesAO::getPermissions(JWTAuth::user()->rol);
            $response['status'] = 200;
        } catch (\Throwable $th) {
            $response['msg'] = "No fue posible obtenerse los roles.";
            Log::error('Error al obtener roles: '.$th->getMessage().' | L: '.$th->getLine().' | F:'.$th->getFile());
        }
        return $response;
    }
}