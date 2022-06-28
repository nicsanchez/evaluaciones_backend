<?php

/*
    Capa de lógica de negocios: capa en la que se procesa la lógica de negocio del módulo de Correos Electrónicos
    Author: David Nicolás Sánchez Sendoya, Augusto Enrique Salazar
*/
namespace App\BL\Emails;

use App\AO\Emails\EmailsAO;
use App\BL\Logs\LogsBL;
use Log;
use App\Imports\EmailsBulkImport;
use Maatwebsite\Excel\Facades\Excel;
use App\AO\Evaluations\EvaluationsAO;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\EvaluationMailReceived;
use App\Imports\GetMassiveEmails;

class EmailsBL{

    /* Método para almacenar o actualizar los correos electrónicos asociados a las cedulas de los profesores */
    public static function storeEmailsByBulkFile($file){
        $response['status'] = 400;
        try {
            $emailsList = new EmailsBulkImport;
            Excel::import($emailsList, $file);
            $response['errors'] = $emailsList::$errors;
            $response['status'] = 200;
            LogsBL::saveLog('Correos','Se ha actualizado el listado de correos.');
        } catch (\Throwable $th) {
            $response['msg'] = "No fue posible actualizarse el listado de correos electrónicos almacenados en el servidor.";
            Log::error('No fue posible actualizarse el listado de correos electrónicos almacenados en el servidor | E: '.$th->getMessage().' | L: '.$th->getLine().' | F:'.$th->getFile());
        }
        return $response;
    }

    
    public static function sendEvaluationMailToUserByDocument($document){
        $response['status'] = 400;
        try {
            $evaluation = EvaluationsAO::getEvaluationAndMailByDocument($document);
            $storagePath = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
            $mail = [
                'filename' => $evaluation[0]->filename.'.pdf',
                'path' => $storagePath."evaluations\\".$evaluation[0]->hashname,
                'body' => 'Cordial saludo, a continuación se adjunta su evaluación docente.'
            ];
            $receiver = $evaluation[0]->email;
            Mail::to($receiver)->send(new EvaluationMailReceived($mail));
            $response['status'] = 200;
        } catch (\Throwable $th) {
            $response['msg'] = "No fue posible enviarse la evaluación al docente.";
            Log::error('No fue posible enviarse la evaluación al docente. | E: '.$th->getMessage().' | L: '.$th->getLine().' | F:'.$th->getFile());
        }
        return $response;
    }

    public static function sendEvaluationsMailsToMultipleUsers($file){
        $response['status'] = 400;
        try {
            $emailsList = new GetMassiveEmails;
            Excel::import($emailsList, $file);
            foreach ($emailsList::$evaluations as $evaluation) {
                $storagePath = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
                $mail = [
                    'filename' => $evaluation['filename'],
                    'path' => $storagePath."evaluations\\".$evaluation['hashname'],
                    'body' => 'Cordial saludo, a continuación se adjunta su evaluación docente.'
                ];
                Mail::to($evaluation['receiver'])->send(new EvaluationMailReceived($mail));
            }
            $response['errors'] = $emailsList::$errors;
            $response['sendMails'] = (count($emailsList::$evaluations) > 0) ? true : false;
            $response['status'] = 200;
        } catch (\Throwable $th) {
            $response['msg'] = "No fue posible enviarse la evaluación a los docentes ingresados en el documento xsls.";
            Log::error('No fue posible enviarse la evaluación a los docentes ingresados en el documento xsls. | E: '.$th->getMessage().' | L: '.$th->getLine().' | F:'.$th->getFile());
        }
        return $response;
    }
}