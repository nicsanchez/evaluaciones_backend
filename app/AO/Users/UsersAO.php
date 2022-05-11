<?php

/*
    Capa de accesos a bases de datos: capa usada para realizar consultas a la base de datos de usuarios
    Author: David Nicolás Sánchez Sendoya, Augusto Enrique Salazar
*/
namespace App\AO\Users;

use DB;

class UsersAO{
    
    /* Método usado para obtener información no sensible de los usuarios de base de datos*/
    public static function getUsers($itemsPerPage,$search){
        $result = DB::table('users')->select('id','name','lastname','email','document','username','rol');
        if($search !== '' && $search !== null){
            $result = $result->where('document','LIKE',$search.'%')->paginate($itemsPerPage);
        }else{
            $result = $result->paginate($itemsPerPage);
        }
        return $result;
    }

    /* Método usado para almacenar la información de un nuevo usuario en base de datos*/
    public static function createUser($data){
        DB::table('users')->insert([
            'name' => $data['name'],
            'lastname' => $data['lastname'],
            'email' => $data['mail'],
            'document' => $data['document'],
            'password' => $data['password'],
            'username' => $data['username'],
            'rol' => $data['rol']
        ]);
    }

    /* Método usado para actualizar la información de un usuario en base de datos*/
    public static function updateUser($id,$data){
        DB::table('users')->where('id',$id)->update($data);
    }

    /* Método usado para eliminar un usuario en base de datos*/
    public static function deleteUser($id){
        DB::table('users')->where('id',$id)->delete();
    }

    /* Método usado para obtener información no sensible de un usuario de base de datos*/
    public static function getUser($id){
        return DB::table('users')->select('id','name','lastname','email','document','username')->where('id',$id)->get();
    }

}