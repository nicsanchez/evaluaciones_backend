<?php

namespace App\Http\Controllers\Roles;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BL\Roles\RolesBL;

class RolesController extends Controller
{
    public function getAllRoles(Request $request){
        return RolesBL::getAllRoles();
    }

    public function getPermissions(Request $request){
        return RolesBL::getPermissions();
    }
}
