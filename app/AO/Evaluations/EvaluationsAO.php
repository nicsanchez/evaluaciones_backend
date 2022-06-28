<?php

/*
    Capa de accesos a bases de datos: capa usada para realizar consultas a la base de datos de las evaluaciones
    Author: David Nicolás Sánchez Sendoya, Augusto Enrique Salazar
*/
namespace App\AO\Evaluations;

use DB;

class EvaluationsAO
{
    /* Método que inserta en la tabla evaluations una evaluación */
    public static function storeFile($data){
        DB::table('evaluations')->insert($data);
    }

    /* Método para truncar la tabla evaluations (borrar todos los registros) */
    public static function deleteEvaluationsTable(){
        DB::table('evaluations')->truncate();
    }

    /* Método para obtener las evaluaciones con paginación */
    public static function getEvaluations($itemsPerPage,$search){
        $result = DB::table('evaluations as e')
            ->leftJoin('emails as m','e.document','m.document')
            ->select('e.*','m.email');
        if($search !== '' && $search !== null){
            $result = $result->where('e.document','LIKE',$search.'%')->paginate($itemsPerPage);
        }else{
            $result = $result->paginate($itemsPerPage);
        }
        return $result;
    }

    /* Método para obtener una evaluación por numero de documento de usuario */
    public static function getEvaluation($document){
        return DB::table('evaluations')->where('document',$document)->get();
    }

    /* Método para obtener una evaluación y correo para el envio via email con el número de cedula del docente*/
    public static function getEvaluationAndMailByDocument($document){
        return DB::table('evaluations as e')
                ->join('emails as m','e.document','m.document')
                ->select('e.hashname','e.filename','m.email')
                ->where('e.document',$document)
                ->get();
    }
}