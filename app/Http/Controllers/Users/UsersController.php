<?php

/*
    Capa Controlador: Capa de validación de datos mediante el uso de Requests para el módulo de usuarios
    Author: David Nicolás Sánchez Sendoya, Augusto Enrique Salazar
*/

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BL\Users\UsersBL;
use App\Http\Requests\Users\createUser;
use App\Http\Requests\Users\editUser;
use App\Http\Requests\Users\editLoggedUser;

class UsersController extends Controller
{
    public function getUsers(Request $request){
        return UsersBL::getUsers($request->input());
    }

    public function getUser(Request $request){
        return UsersBL::getUser();
    }

    public function createUser(createUser $request){
        return UsersBL::createUser($request->input());
    }

    public function updateUser(editUser $request){
        return UsersBL::updateUser($request->input('data'));
    }

    public function updatePersonalData(editLoggedUser $request){
        return UsersBL::updatePersonalData($request->input('data'));
    }

    public function deleteUser(Request $request){
        return UsersBL::deleteUser($request->input());
    }
}
