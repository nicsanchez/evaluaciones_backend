<?php

/*
    Capa de accesos a bases de datos: capa usada para realizar consultas a la base de datos de logs
    Author: David Nicolás Sánchez Sendoya, Augusto Enrique Salazar
*/
namespace App\AO\Logs;

use DB;

class LogsAO
{
    /* Método usado para registrar información en base de datos*/
    public static function saveLog($data){
        DB::table('logs')->insert($data);
    }

    /* Método usado para obtener registro de actividad de base de datos*/
    public static function getLogs($itemsPerPage){
        return DB::table('logs as l')
        ->join('users as u', 'l.usuario', '=', 'u.id')
        ->select('u.name','u.lastname','l.modulo','l.accion','l.created_at')
        ->paginate($itemsPerPage);
    }

}