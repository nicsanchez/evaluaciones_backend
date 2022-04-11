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
use ZipArchive;
use App\Imports\EvaluationsSearch;
use Maatwebsite\Excel\Facades\Excel;

class EvaluationsBL{

    /* Método para almacenar las evaluaciones en PDF adjuntas */
    public static function saveAttachments($data){
        $response['status'] = 400;
        $response['errors'] = self::validateFileNames($data);
        if(sizeof($response['errors']) == 0){
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
                Log::error('Error al almacenarse las evaluaciones | E: '.$th->getMessage().' | L: '.$th->getLine().' | F:'.$th->getFile());
            }
        }

        return $response;
    }

    /* Método para validar que el nombre del PDF adjunto (Nombre-cedula.pdf) */
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

    /* Método para obtener todas las evaluaciones almacenadas en el servidor y BD usando paginación */
    public static function getEvaluations($data){
        $response['status'] = 400;
        try {
            $response['data'] = EvaluationsAO::getEvaluations($data['itemsPerPage'],$data['search']);
            $response['status'] = 200;
        } catch (\Throwable $th) {
            $response['msg'] = "No fue posible obtenerse las evaluaciones almacenadas al servidor.";
            Log::error('No fue posible obtenerse las evaluaciones almacenadas al servidor | E: '.$th->getMessage().' | L: '.$th->getLine().' | F:'.$th->getFile());
        }
        return $response;
    }

    /* Método para descargar una evaluacion por su nombre de archivo */
    public static function downloadFileByFilename($filename){
        $response['status'] = 400;
        try {
            $response['data'] = base64_encode(Storage::disk('local')->get('evaluations/'.$filename));
            $response['status'] = 200;
        } catch (\Throwable $th) {
            $response['msg'] = "No fue posible descargarse la evaluación almacenada en el servidor.";
            Log::error('No fue posible descargarse la evaluación almacenada en el servidor | E: '.$th->getMessage().' | L: '.$th->getLine().' | F:'.$th->getFile());
        }
        return $response;
    }

    /* Método para descargar las evaluaciones de docentes adjuntas en un documento excel (xls,xlsx) */
    public static function downloadFilesByBulkFile($file){
        $response['status'] = 400;
        try {
            $downloadList = new EvaluationsSearch;
            Excel::import($downloadList, $file);
            if(sizeof($downloadList::$evaluations) > 0){
                $zip = new ZipArchive;
                $fileName = 'Evaluaciones.zip';
                $storagePath = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
                $zip->open($storagePath.'\\'.$fileName,ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE);
                foreach ($downloadList::$evaluations as $evaluation) {
                    $evaluationFile = $storagePath."evaluations\\".$evaluation['hashname'];
                    $zip->addFile($evaluationFile, $evaluation['filename']);
                }
                $zip->close();
                $response['evaluations'] = base64_encode(Storage::disk('local')->get($fileName));
            }
            $response['errors'] = $downloadList::$errors;
            $response['status'] = 200;
        } catch (\Throwable $th) {
            $response['msg'] = "No fue posible descargarse el listado de evaluaciones almacenados en el servidor.";
            Log::error('No fue posible descargarse el listado de evaluaciones almacenados en el servidor | E: '.$th->getMessage().' | L: '.$th->getLine().' | F:'.$th->getFile());
        }
        return $response;
    }

}