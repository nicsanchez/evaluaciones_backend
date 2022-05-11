<?php

/*
    Capa de accesos a bases de datos: capa usada para realizar consultas a la base de datos de roles
    Author: David Nicolás Sánchez Sendoya, Augusto Enrique Salazar
*/
namespace App\AO\Roles;

use DB;

class RolesAO{
    
    /* Método usado para obtener todos los roles */
    public static function getAllRoles(){
        return DB::table('roles')
            ->select('id','name')
            ->get();
    }

    /* Método usado para obtener el rol del usuario en sesión */
    public static function getPermissions($rol){
        return DB::table('roles')
            ->select('key')
            ->where('id',$rol)
            ->get();
    }
}