<?php

namespace App\Http\Requests\Evaluations;

use Illuminate\Foundation\Http\FormRequest;

class downloadFilesBulk extends FormRequest
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

    /* Definición de reglas para la API relacionada con la descarga de multiples evaluaciones de docentes especificados en un archivo excel */
    public function rules()
    {
        return [
            'file' => 'file|mimes:xls,xlsx'
        ];
    }
}
