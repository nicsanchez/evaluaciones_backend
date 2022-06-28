<?php

/*
    Capa Controlador: Capa de validación de datos mediante el uso de Requests para el módulo de emails
    Author: David Nicolás Sánchez Sendoya, Augusto Enrique Salazar
*/

namespace App\Http\Controllers\Emails;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BL\Emails\EmailsBL;
use App\Http\Requests\Emails\validateBulkFile;
use App\Http\Requests\Emails\sendIndividualMail;

class EmailsController extends Controller
{
    public function storeEmailsByBulkFile(validateBulkFile $request){
        return EmailsBL::storeEmailsByBulkFile($request->file);
    }

    public function sendEvaluationMailToUserByDocument(sendIndividualMail $request){
        return EmailsBL::sendEvaluationMailToUserByDocument($request->document);
    }

    public function sendEvaluationsMailsToMultipleUsers(validateBulkFile $request){
        return EmailsBL::sendEvaluationsMailsToMultipleUsers($request->file);
    }
}