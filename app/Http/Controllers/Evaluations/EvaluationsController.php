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
use App\Http\Requests\Evaluations\downloadFilesBulk;
use App\Http\Requests\Evaluations\downloadFile;

class EvaluationsController extends Controller
{
    public function saveAttachments(evaluationsBulk $request){
        return EvaluationsBL::saveAttachments($request->all());
    }

    public function getEvaluations(Request $request){
        return EvaluationsBL::getEvaluations($request->input());
    }

    public function downloadFileByFilename(downloadFile $request){
        return EvaluationsBL::downloadFileByFilename($request->filename);
    }

    public function downloadFilesByBulkFile(downloadFilesBulk $request){
        return EvaluationsBL::downloadFilesByBulkFile($request->file);
    }
}
