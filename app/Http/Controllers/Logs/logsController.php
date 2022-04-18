<?php

namespace App\Http\Controllers\Logs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BL\Logs\LogsBL;

class logsController extends Controller
{
    public function getLogs(Request $request){
        return LogsBL::getLogs($request->input());
    }
}
