<?php

/*
    Capa de accesos a bases de datos: capa usada para realizar consultas a la base de datos de los Correos
    Author: David Nicolás Sánchez Sendoya, Augusto Enrique Salazar
*/
namespace App\AO\Emails;

use DB;

class EmailsAO
{
    /* Método que inserta en la tabla emails un correo electrónico asociado a una cedula */
    public static function storeEmail($data){
        DB::table('emails')->insert($data);
    }

    /* Método usado para actualizar un correo asociado a una cedula en base de datos*/
    public static function updateEmail($id,$data){
        DB::table('emails')->where('id',$id)->update($data);
    }

    /* Método usado para obtener un correo asociado a una cedula en base de datos*/
    public static function getEmailByDocument($document){
        return DB::table('emails')->where('document',$document)->get();
    }
}