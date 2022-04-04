<?php

/*
    Capa de lógica de negocios: capa en la que se procesa la lógica de negocio del módulo de usuarios
    Author: David Nicolás Sánchez Sendoya, Augusto Enrique Salazar
*/
namespace App\BL\Users;
use App\AO\Users\UsersAO;
use Illuminate\Support\Facades\Hash;
use Log;

class UsersBL
{
    public static function getUsers($itemsPerPage){
        $response['status'] = 400;
        try {
            $response['data'] = UsersAO::getUsers($itemsPerPage);
            $response['status'] = 200;
        } catch (\Throwable $th) {
            $response['msg'] = "No fue posible obtenerse los usuarios.";
            Log::error('Error al obtener usuarios: '.$th->getMessage().' | L: '.$th->getLine().' | F:'.$th->getFile());
        }

        return $response;
    }

    public static function createUser($data){
        $response['status'] = 400;
        try {
            $data['password'] = Hash::make($data['password']);
            $response['data'] = UsersAO::createUser($data);
            $response['status'] = 200;
        } catch (\Throwable $th) {
            $response['msg'] = "No fue posible crearse el usuario.";
            Log::error('Error al crear el usuario: '.$th->getMessage().' | L: '.$th->getLine().' | F:'.$th->getFile());
        }

        return $response;
    }


    public static function deleteUser($data){
        $response['status'] = 400;
        try {
            $response['data'] = UsersAO::deleteUser($data['id']);
            $response['status'] = 200;
        } catch (\Throwable $th) {
            $response['msg'] = "No fue posible eliminarse el usuario.";
            Log::error('Error al eliminar el usuario: '.$th->getMessage().' | L: '.$th->getLine().' | F:'.$th->getFile());
        }

        return $response;
    }

    public static function updateUser($data){
        $response['status'] = 400;
        try {
            $dataUpdate = [
                'name' => $data['name'],
                'lastname' => $data['lastname'],
                'email' => $data['email'],
                'document' => $data['document'],
                'username' => $data['username'],
            ];

            if(isset($data['password']) && $data['password'] != ""){
                $dataUpdate['password'] = Hash::make($data['password']);
            }
            $response['data'] = UsersAO::updateUser($data['id'],$dataUpdate);
            $response['status'] = 200;
        } catch (\Throwable $th) {
            $response['msg'] = "No fue posible crearse el usuario.";
            Log::error('Error al crear el usuario: '.$th->getMessage().' | L: '.$th->getLine().' | F:'.$th->getFile());
        }

        return $response;
    }

    public static function getUser($data){
        $response['status'] = 400;
        try {
            $response['data'] = UsersAO::getUser($data['id']);
            $response['status'] = 200;
        } catch (\Throwable $th) {
            $response['msg'] = "No fue posible obtenerse el usuario.";
            Log::error('Error al obtenerse el usuario: '.$th->getMessage().' | L: '.$th->getLine().' | F:'.$th->getFile());
        }
        return $response;
    }
}