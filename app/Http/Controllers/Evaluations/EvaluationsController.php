<?php

/*
    Capa Controlador: Capa de validación de datos mediante el uso de Requests para el módulo de evaluaciones
    Author: David Nicolás Sánchez Sendoya, Augusto Enrique Salazar
*/

namespace App\Http\Controllers\Evaluations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BL\Evaluations\EvaluationsBL;
use App\Http\Requests\Evaluations\evaluationsBulk;

class EvaluationsController extends Controller
{
    public function saveAttachments(evaluationsBulk $request){
        return EvaluationsBL::saveAttachments($request->all());
    }

}
