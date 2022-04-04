<?php

/*
    Capa de accesos a bases de datos: capa usada para realizar consultas a la base de datos de usuarios
    Author: David Nicolás Sánchez Sendoya, Augusto Enrique Salazar
*/
namespace App\AO\Users;

use DB;

class UsersAO
{
    public static function getUsers($itemsPerPage){
        return DB::table('users')
            ->select('id','name','lastname','email','document','username')
            ->paginate($itemsPerPage);
    }

    public static function createUser($data)
    {
        DB::table('users')->insert([
            'name' => $data['name'],
            'lastname' => $data['lastname'],
            'email' => $data['mail'],
            'document' => $data['document'],
            'password' => $data['password'],
            'username' => $data['username']
        ]);
    }

    public static function updateUser($id,$data)
    {
        DB::table('users')->where('id',$id)->update($data);
    }

    public static function deleteUser($id){
        DB::table('users')->where('id',$id)->delete();
    }

    public static function getUser($id){
        return DB::table('users')->select('id','name','lastname','email','document','username')->where('id',$id)->get();
    }

}