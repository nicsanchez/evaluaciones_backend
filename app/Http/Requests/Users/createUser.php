<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class createUser extends FormRequest
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
            'name' => 'required|string|max:50',
            'lastname' => 'required|string|max:50',
            'mail' => 'required|email|max:50|unique:users,email',
            'document' => 'required|numeric|digits_between:6,15|unique:users,document',
            'username' => 'required|unique:users,username',
            'password' => 'required',
        ];
    }
}
