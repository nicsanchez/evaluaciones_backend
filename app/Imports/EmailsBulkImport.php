<?php

namespace App\Imports;

use App\Http\Requests\Emails\storeEmails;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;
use App\AO\Emails\EmailsAO;
use Carbon\Carbon;

/*
    Capa de procesamiento de archivo excel: capa usada para procesar archivo xls con un listado de correos
    asociados a una cedula.
    Author: David Nicolás Sánchez Sendoya, Augusto Enrique Salazar
*/

class EmailsBulkImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public static $errors = [];

    public function collection($rows)
    {
        $cont = 0;
        $storeEmailsRequests = new storeEmails();
        foreach ($rows as $row) {
            $cont += 1;
            if($row->filter()->isNotEmpty()){
                $data = [
                    'email' => $row[1],
                    'document' => $row[0],
                    'created_at' => Carbon::now()
                ];
                $validator = Validator::make($data, $storeEmailsRequests->rules(), $storeEmailsRequests->messages());

                if ($validator->fails()) {
                    self::$errors[] = ['row' => $cont, 'errors' => $validator->errors()->all()];
                }else{
                    $email = EmailsAO::getEmailByDocument($row[0]);
                    if($email->count() !== 0){
                        EmailsAO::updateEmail($email[0]->id,$data);
                    }else{
                        EmailsAO::storeEmail($data);
                    }  
                }

            }
        }
    }
}
