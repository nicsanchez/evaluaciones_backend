<?php

/*
    Capa de lógica de negocios: capa en la que se procesa la lógica de negocio del módulo de Logs
    Author: David Nicolás Sánchez Sendoya, Augusto Enrique Salazar
*/
namespace App\BL\Logs;

use Carbon\Carbon;
use App\AO\Logs\LogsAO;
use Log;
use JWTAuth;

class LogsBL{

    /* Método para almacenar las evaluaciones en PDF adjuntas */
    public static function saveLog($modulo,$accion){
        try {
            $data = [
                'modulo' => $modulo,
                'accion' => $accion,
                'usuario' => JWTAuth::user()->id,
                'created_at' => Carbon::now()
            ];
            LogsAO::saveLog($data);
        } catch (\Throwable $th) {
            Log::error('Error al almacenarse Log | E: '.$th->getMessage().' | L: '.$th->getLine().' | F:'.$th->getFile());
        }        
    }

    /* Método para obtener los registros de actividad almacenados en base de datos usando paginación */
    public static function getLogs($data){
        $response['status'] = 400;
        try {
            $response['data'] = LogsAO::getLogs($data['itemsPerPage']);
            $response['status'] = 200;
        } catch (\Throwable $th) {
            $response['msg'] = "No fue posible obtenerse los registros de actividad almacenados en el servidor.";
            Log::error('No fue posible obtenerse los registros de actividad almacenados en el servidor | E: '.$th->getMessage().' | L: '.$th->getLine().' | F:'.$th->getFile());
        }
        return $response;
    }
}