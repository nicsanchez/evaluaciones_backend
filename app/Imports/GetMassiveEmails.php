<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\AO\Evaluations\EvaluationsAO;
use App\AO\Emails\EmailsAO;

class GetMassiveEmails implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public static $errors = [];
    public static $evaluations = [];

    public function collection($rows)
    {
        $cont = 0;
        foreach ($rows as $row) {
            $cont += 1;
            if($row->filter()->isNotEmpty()){
                $evaluation = EvaluationsAO::getEvaluation($row[0]);
                if($evaluation->count() !== 0){
                    $email = EmailsAO::getEmailByDocument($row[0]);
                    if($email->count() !== 0){
                        self::$evaluations[] = [
                            'receiver' => $email[0]->email,
                            'hashname' => $evaluation[0]->hashname,
                            'filename' => $evaluation[0]->filename.'.pdf',
                        ];
                    }else{
                        self::$errors[] = ['row' => $cont, 'error' => 'La cedula ingresada no tiene un correo registrado en base de datos.'];
                    } 
                }else{
                    self::$errors[] = ['row' => $cont, 'error' => 'La cedula ingresada no tiene una evaluación almacenada en base de datos.'];
                }
            }
        }
    }
}
