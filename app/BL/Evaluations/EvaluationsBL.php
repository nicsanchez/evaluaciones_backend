<?php

/*
    Capa de lógica de negocios: capa en la que se procesa la lógica de negocio del módulo de evaluaciones
    Author: David Nicolás Sánchez Sendoya, Augusto Enrique Salazar
*/
namespace App\BL\Evaluations;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\AO\Evaluations\EvaluationsAO;
use Log;

class EvaluationsBL{

    public static function saveAttachments($data){
        $response['status'] = 400;
        $response['errors'] = self::validateFileNames($data);
        if(sizeof($response['errors']) > 0){
            print_r('paila');
        }else{
            try {
                Storage::deleteDirectory('evaluations');
                EvaluationsAO::deleteEvaluationsTable();
                foreach ($data as $file) {
                    $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $dataFile = [
                        'filename' => $fileName,
                        'name' => explode('-',$fileName)[0],
                        'document' => explode('-',$fileName)[1],
                        'hashname' => $file->hashName(),
                        'created_at' => Carbon::now()
                    ];
                    EvaluationsAO::storeFile($dataFile);
                    $file->store('evaluations','local');
                }
                $response['status'] = 200;
            } catch (\Throwable $th) {
                $response['msg'] = "No fue posible almacenarse las evaluaciones en el servidor.";
                Log::error('Error al almacenarse las evaluaciones: '.$th->getMessage().' | L: '.$th->getLine().' | F:'.$th->getFile());
            }
        }

        return $response;
    }

    public static function validateFileNames($files){
        $errors = [];
        foreach ($files as $file) {
            $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            if(!preg_match('/^([a-zA-ZÀ-ÿ ]{3,})-([0-9]{6,15})+$/', $fileName)){
                array_push($errors,$fileName);
            }
            
        }
        return $errors;
    }


}