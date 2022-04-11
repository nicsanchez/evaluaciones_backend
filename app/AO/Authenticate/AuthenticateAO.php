<?php

/*
    Capa de accesos a bases de datos relacionados con el inicio de sessión
    Author: David Nicolás Sánchez Sendoya, Augusto Enrique Salazar
*/
namespace App\AO\Authenticate;

use DB;

class AuthenticateAO
{
    /* Método usado para obtener un usuario en base de datos con el fin de verificar si existe o no. */
    public static function getUserByUsername($username){
        return DB::table('users')->select('email')->where('username',$username)->get()->toArray();
    }

}