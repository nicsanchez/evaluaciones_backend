<?php

namespace App\Http\Requests\Emails;

use Illuminate\Foundation\Http\FormRequest;

class storeEmails extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email|max:50',
            'document' => 'required|numeric|digits_between:6,15'
        ];
    }

    public function messages()
    {
        return [
            'email.required'                    => 'El correo es obligatorio',
            'document.required'                 => 'El número de documento es obligatorio',
            'email.email'                       => 'El correo no tiene el formato válido',
            'document.numeric'                  => 'El número de documento es numérico',
            'email.max'                         => 'El correo no debe superar 50 caracteres',
            'document.digits_between'           => 'El numero de documento debe estar entre 6 y 15 caracteres',
        ];
    }

}
