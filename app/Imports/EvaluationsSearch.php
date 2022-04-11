<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\AO\Evaluations\EvaluationsAO;

/*
    Capa de procesamiento de archivo excel: capa usada para procesar archivo xls con cedulas de usuario
    donde se verifica que docentes tienen evaluaciones registradas en el sistema
    Author: David Nicolás Sánchez Sendoya, Augusto Enrique Salazar
*/

class EvaluationsSearch implements ToCollection
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
                    self::$evaluations[] = ['filename' => $evaluation[0]->filename.'.pdf', 'hashname' => $evaluation[0]->hashname];
                }else{
                    self::$errors[] = ['fila' => $cont, 'cedula' => $row[0]];
                }
            }
        }
    }
}
