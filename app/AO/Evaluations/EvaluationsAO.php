<?php

/*
    Capa de accesos a bases de datos: capa usada para realizar consultas a la base de datos de las evaluaciones
    Author: David Nicolás Sánchez Sendoya, Augusto Enrique Salazar
*/
namespace App\AO\Evaluations;

use DB;

class EvaluationsAO
{

    public static function storeFile($data)
    {
        DB::table('evaluations')->insert($data);
    }

    public static function deleteEvaluationsTable(){
        DB::table('evaluations')->truncate();
    }
}