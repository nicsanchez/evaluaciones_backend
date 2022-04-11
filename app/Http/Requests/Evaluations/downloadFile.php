<?php

namespace App\Http\Requests\Evaluations;

use Illuminate\Foundation\Http\FormRequest;

class downloadFile extends FormRequest
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

    /* Definición de reglas para la API relacionada con la descarga de una evaluacion por su nombre pdf */
    public function rules()
    {
        return [
            'filename' => 'required|string|max:255',
        ];
    }
}
