<?php

namespace App\Http\Requests\Evaluations;

use Illuminate\Foundation\Http\FormRequest;

class evaluationsBulk extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /* Definición de reglas para la API relacionada con el cargue masivo de evaluaciones PDF en el servidor */
    public function rules()
    {
        return [
            '*' => 'file|mimes:zip'
        ];
    }
}
