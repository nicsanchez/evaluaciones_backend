<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use JWTAuth;

class editLoggedUser extends FormRequest
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

    /* Definición de reglas para la API relacionada con la actualización de usuarios */
    public function rules()
    {
        return [
            'data' => 'required|array',
            'data.name' => 'required|string|max:50',
            'data.lastname' => 'required|string|max:50',
            'data.email' => 'required|email|max:50|unique:users,email,'.JWTAuth::user()->id,
            'data.document' => 'required|numeric|digits_between:6,15|unique:users,document,'.JWTAuth::user()->id,
            'data.username' => 'required|unique:users,username,'.JWTAuth::user()->id,
            'data.rol' => 'required',
        ];
    }
}
